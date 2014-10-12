# Toggl SDK

Lightweight and unobtrusive domain library pointed at the V8 toggl API.

If you are looking for a low-coupling option to integrate toggl into your project or are considering extending
their domain, this library could be of some use to you!

This library maintains minimal dependencies and attempts to be as well documented and designed as possible so
that extending it is a snap.


## Setup

 * Add `atrauzzi/toggl-sdk` to your `composer.json` file.
 * Run `composer update` at the root of your project.


## Configuring

Before making calls against the library, be sure to call one of the following static methods on
`Atrauzzi\TogglSdk\Domain\Repository\Api\Base`.  This can normally be done somehwere from within your
framework's bootstrap where configuration is parsed.

### ::setApiToken($apiToken)
Assigns the API token.  Don't worry about any special handling, it's all done for you.

### ::setCookie($cookie)
Uses a pre-existing cookie issued by toggl themselves.

### ::setCredentials($username, $password)
Calls authenticate using a regular username and password.

---

Ideally, you'll be using this library with the help of a dependency injection container.  If the container supports
automatic constructor injection, you probably won't even have to specify the bindings.

## Basic Usage

Instances of toggl domain objects can be created and persisted using the repositories.  You can either manually
instantiate the repositories, or request them via your dependency injection container.


## Extending

If for any reason you wish to extend the default toggl domain, your best option will be to depend on this package
from either your project or another portable library.  From there you can subclass the model and repository structure
excluding utility classes.

When performing save and load operations, your subclasses can still access the toggl API by calling parent methods
remaining fully capable of fulfilling the base package's repository interfaces. All things considered, this is pretty
straightforward and will ensure that you remain compatible with the SDK.

And of course, don't forget to add new repository interfaces and model attributes of your own in your package/project!


## Meta

*Progress on this library is ongoing as the project that spawned it grows. If there's a specific feature you wish to
implement or see prioritized, please let me know!*

The documentation and some of the functionality in this library is still evolving.  If there's a feature or improvement
that you would like to contribute or suggest, please don't hesitate to open a github ticket! :)

### Credits

Toggl SDK is created and maintained by [Alexander Trauzzi](http://goo.gl/qWhdWz)