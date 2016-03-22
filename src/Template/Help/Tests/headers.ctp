<h2 data-scrollto="sts" style="margin-top: 0px;">Strict-Transport-Security</h2>
<p>HTTP Strict Transport Security (often abbreviated as HSTS) is a security feature that lets a web site tell browsers that it should only be communicated with using HTTPS, instead of using HTTP.</p>
<p>Enabling this feature for your site is as simple as returning the Strict-Transport-Security HTTP header when your site is accessed over HTTPS:</p>
<blockquote>Strict-Transport-Security: max-age=expireTime [; includeSubDomains]</blockquote>
<p><strong>max-age</strong></p>
<p>The time, in seconds, that the browser should remember that this site is only to be accessed using HTTPS.</p>
<p><strong>includeSubDomains Optional</strong></p>
<p>If this optional parameter is specified, this rule applies to all of the site's subdomains as well.</p>
<p><h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set Strict-Transport-Security "max-age=31536000; includeSubdomains;"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="Strict-Transport-Security" value="max-age=31536000"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;</pre></blockquote>
<h4>References</h4>
<p><a href="https://developer.mozilla.org/en-US/docs/Web/Security/HTTP_strict_transport_security">https://developer.mozilla.org/en-US/docs/Web/Security/HTTP_strict_transport_security</a></p>
<p><a href="https://www.owasp.org/index.php/HTTP_Strict_Transport_Security">https://www.owasp.org/index.php/HTTP_Strict_Transport_Security</a></p>

<h2 data-scrollto="xfo">X-Frame-Options</h2>
<p>The X-Frame-Options HTTP response header can be used to indicate whether or not a browser should be allowed to render a page in a &lt;frame&gt;, &lt;iframe&gt; or &lt;object&gt; . Sites can use this to avoid clickjacking attacks, by ensuring that their content is not embedded into other sites.</p>
<p>There are three possible values for X-Frame-Options:</p>

<strong>DENY</strong>
<p>The page cannot be displayed in a frame, regardless of the site attempting to do so.</p>
<strong>SAMEORIGIN</strong>
<p>The page can only be displayed in a frame on the same origin as the page itself.</p>
<strong>ALLOW-FROM uri</strong>
<p>The page can only be displayed in a frame on the specified origin.</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set X-Frame-Options "SAMEORIGIN"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="X-Frame-Options" value="SAMEORIGIN"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header X-Frame-Options "SAMEORIGIN" always;</pre></blockquote>
<h4>References</h4>
<p><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/X-Frame-Options">https://developer.mozilla.org/en-US/docs/Web/HTTP/X-Frame-Options</a>

<h2 data-scrollto="xxp">X-XSS-Protection</h2>
<p>This header enables the Cross-site scripting (XSS) filter built into most recent web browsers. It's usually enabled by default anyway, so the role of this header is to re-enable the filter for this particular website if it was disabled by the user.</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set X-XSS-Protection "1; mode=block"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="X-XSS-Protection" value="1; mode=block"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header X-Xss-Protection "1; mode=block" always;</pre></blockquote>
<h4>References</h4>
<p><a href="https://www.owasp.org/index.php/List_of_useful_HTTP_headers">https://www.owasp.org/index.php/List_of_useful_HTTP_headers</a>
<h2 data-scrollto="xcto">X-Content-Type-Options</h2>
<p>The only defined value, "nosniff", prevents Internet Explorer and Google Chrome from MIME-sniffing a response away from the declared content-type. This also applies to Google Chrome, when downloading extensions. This reduces exposure to drive-by download attacks and sites serving user uploaded content that, by clever naming, could be treated by MSIE as executable or dynamic HTML files.</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set X-Content-Type-Options "nosniff"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="X-Content-Type-Options" value="nosniff"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header X-Content-Type-Options "nosniff" always;</pre></blockquote>
<h4>References</h4>
<p><a href="https://www.owasp.org/index.php/List_of_useful_HTTP_headers">https://www.owasp.org/index.php/List_of_useful_HTTP_headers</a>
<h2 data-scrollto="csp">Content-Security-Policy</h2>
<p>The Content-Security-Policy header offers the possbility to instruct the client browser from which location and/or which type of resources are allowed to be loaded. To define a loading behavior, the CSP specification use "directive" where a directive defines a loading behavior for a target resource type.</p>
<p>Several online tools are avaliable to help you generate a Content-Security-Policy header, one good example is the CSP Is Awesome tool available at <a href="http://cspisawesome.com/">http://cspisawesome.com/</a>.</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set Content-Security-Policy "default-src https: data: 'unsafe-inline' 'unsafe-eval'"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="Content-Security-Policy" value="default-src https: data: 'unsafe-inline' 'unsafe-eval'"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header Content-Security-Policy "default-src https: data: 'unsafe-inline' 'unsafe-eval'" always;</pre></blockquote>
<h4>References</h4>
<p><a href="https://www.owasp.org/index.php/Content_Security_Policy">https://www.owasp.org/index.php/Content_Security_Policy</a></p>
<p><a href="http://cspisawesome.com/">http://cspisawesome.com/</a></p>

<h2 data-scrollto="pkp">Public-Key-Pins</h2>
<p>The Public Key Pinning Extension for HTTP (HPKP) is a security feature that tells a web client to associate a specific cryptographic public key with a certain web server to prevent MITM attacks with forged certificates.</p>
<p>Follow the instructions available on the <a href="https://developer.mozilla.org/en/docs/Web/Security/Public_Key_Pinning#Extracting_the_Base64_encoded_public_key_information">Mozilla website</a> for detailed instructions on how to extract the required information from your certificates.
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>Header always set Public-Key-Pins "pin-sha256=\"base64+primary==\"; pin-sha256=\"base64+backup==\"; max-age=5184000; includeSubDomains"</pre></blockquote>
<h4>IIS</h4>
<blockquote><pre>&lt;system.webServer&gt;
    &lt;httpProtocol&gt;
        &lt;customHeaders&gt;
            &lt;add name="Public-Key-Pins" value="pin-sha256=&quot;base64+primary==&quot;; pin-sha256=&quot;base64+backup==&quot;; max-age=5184000; includeSubDomains"/&gt;
        &lt;/customHeaders&gt;
    &lt;/httpProtocol&gt;
&lt;/system.webServer&gt;</pre></blockquote>
<h4>nginx</h4>
<blockquote><pre>add_header Public-Key-Pins 'pin-sha256="base64+primary=="; pin-sha256="base64+backup=="; max-age=5184000; includeSubDomains';</pre></blockquote>
<h4>References</h4>
<p><a href="https://developer.mozilla.org/en/docs/Web/Security/Public_Key_Pinning">https://developer.mozilla.org/en/docs/Web/Security/Public_Key_Pinning</a>
