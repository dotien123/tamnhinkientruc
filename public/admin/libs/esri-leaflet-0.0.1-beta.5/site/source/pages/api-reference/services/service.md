---
layout: documentation.hbs
---

# L.esri.Service

A generic class representing a hosted resource on ArcGIS Online or ArcGIS Server. This class can be extended to provide support for making requests as well as a standard for authentication and proxying.

### Constructor

<table>
    <thead>
        <tr>
            <th>Constructor</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code class="nobr">new L.esri.Services.Service({{{param 'String' 'url'}}}, {{{param 'Object' 'options'}}})</code><br><br><code class="nobr">L.esri.Services.service({{{param 'String' 'url'}}}, {{{param 'Object' 'options'}}})</code></td>
            <td>The `url` parameter is the URL to the ArcGIS Server or ArcGIS Online service you would like to consume.</td>
        </tr>
    </tbody>
</table>

### Options

| Option | Type | Default | Description |
| --- | --- | --- | --- |
| `proxy` | `String` | `false` | URL of an [ArcGIS API for JavaScript proxies](https://developers.arcgis.com/javascript/jshelp/ags_proxy.html) or [ArcGIS Resource Proxies](https://github.com/Esri/resource-proxy) to use for proxying POST requests. |
| `useCORS` | `Boolean` | `true` | If this service should use CORS when making GET requests. |

### Events

| Event | Type | Description |
| --- | --- | --- |
| `requeststart` | [<`RequestEvent`>]({{assets}}api-reference/events.html#request-event) | Fired when a request to the service begins. |
| `requestend` | [<`RequestEvent`>]({{assets}}api-reference/events.html#request-event) | Fired when a request to the service ends. |
| `requestsuccess` | [<`RequestSuccessEvent`>]({{assets}}api-reference/events.html#request-success-event) | Fired when a request to the service was successful. |
| `requesterror` | [<`RequestErrorEvent`>]({{assets}}api-reference/events.html#request-error-event) | Fired when a request to the service responsed with an error. |
| `authenticationrequired` | [<`AuthenticationEvent`>]({{assets}}api-reference/events.html#authentication-event) | This will be fired when a request to the service fails and requires authentication. See [working with authenticated services](#working-with-authenticated-services) for more information. |

### Methods

<table>
    <thead>
        <tr>
            <th>Method</th>
            <td>Returns</td>
            <td>Description</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>get({{{param 'String' 'url'}}}, {{{param 'Object' 'params'}}}, {{{param 'Function' 'callback'}}}, {{{param 'Object' 'context'}}})</code></td>
            <td><code>this</code></td>
            <td>Makes a GET request to the service. The services URL will be combined with the `path` option and parameters will be serialized to a query string. Accepts an optional function context for the callback.</td>
        </tr>
        <tr>
            <td><code>post({{{param 'String' 'url'}}}, {{{param 'Object' 'params'}}}, {{{param 'Function' 'callback'}}}, {{{param 'Object' 'context'}}})</code></td>
            <td><code>this</code></td>
            <td>Makes a POST request to the service. The services URL will be combined with the `path` option and parameters will be serialized. Accepts an optional function context for the callback.</td>
        </tr>
        <tr>
            <td><code>metadata({{{param 'Function' 'callback'}}}, {{{param 'Object' 'context'}}})</code></td>
            <td><code>this</code></td>
            <td>Requests the metadata about the service. This is an alias for get("/", {}, callback, context).</td>
        </tr>
        <tr>
            <td><code>authenticate({{{param 'String' 'token'}}})</code></td>
            <td><code>this</code></td>
            <td>Authenticates this service with a new token and runs any pending requests that required a token.</td>
        </tr>
    </tbody>
</table>
