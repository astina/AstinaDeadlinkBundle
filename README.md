Astina Deadlink Bundle
======================

Symfony bundle that provides services to find broken link URLs.

## Installation

### Step 1: Add to composer.json

```json
"require":  {
    "astina/deadlink-bundle":"dev-master",
}
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Astina\Bundle\DeadlinkBundle\AstinaDeadlinkBundle(),
    );
}
```

##Usage

The bundle provides a command (`astina:deadlink:check`) that checks so called "link sources" for broken links and dispatches a `BrokenLinksEvent` if one or more broken links are found for a given source.

**To create a link source:**

1. Create a class that implements `Astina\Bundle\DeadlinkBundle\Link\LinkSourceInterface`.
2. Configure that class as a service and tag it as `astina_deadlink.link_source`.

**To react to broken links:**

1. Create an event listener.
2. Listen to the `astina_deadlink.broken_links` event.

Example:
```xml
<service id="deadlink_listener" class="Acme\FooBundle\DeadlinkListener">
    <tag name="kernel.event_listener" event="astina_deadlink.broken_links" method="onBrokenLinks" />
</service>
```

```php
namespace Acme\FooBundle;

use Astina\Bundle\DeadlinkBundle\Link\BrokenLinksEvent;

class DeadlinkListener
{
    public function onBrokenLinks(BrokenLinksEvent $event)
    {
        // ZOMG!
    }
}
```

**Find broken links:**

Run the `astina:deadlink:check` command to check all registered link sources for broken links. If a broken link is found, the `astina_deadlink.broken_links` event is dispatched.

####DoctrineLinkSource
If you have are using Doctrine and have an Entity or Document that contain URLs (or text that contains URLs) you can use `Astina\Bundle\DeadlinkBundle\Doctrine\DoctrineLinkSource` and configure a service like this:

```yml
services:
    my_link_source:
        class: Astina\Bundle\DeadlinkBundle\Doctrine\DoctrineLinkSource
        arguments:
            - @doctrine
            - AcmeFooBundle:MyEntity
            - [ text, lead ] # properties of the given entity that contain URLs
            - [] # optional: array of criteria to filter the entities
        tags:
            - { name: astina_deadlink.link_source }
```

