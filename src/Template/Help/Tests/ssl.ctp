<h2 style="margin-top: 0px;">General Protocol Information</h2>
<p>It is recommended to use the <a href="https://mozilla.github.io/server-side-tls/ssl-config-generator/">Mozilla SSL Configuration Generator</a> to help generate SSL configurations for your chosen platform(s).</p>
<h2 data-scrollto="ssl2">SSL 2.0</h2>
<p>SSL 2.0 was deprecated (prohibited) in 2011 and contains various security flaws.</p>
<h3>Removal steps</h3>
<h4>Apache</h4>
<blockquote><pre>SSLProtocol All -SSLv2 -SSLv3</pre></blockquote>
<h4>IIS</h4>
<p>Disabling SSL 2.0 in IIS requires registry edits. Follow the following Microsoft guide for steps: <a href="https://support.microsoft.com/en-us/kb/187498">https://support.microsoft.com/en-us/kb/187498</a></p>
<h4>nginx</h4>
<blockquote><pre>ssl_protocols TLSv1 TLSv1.1 TLSv1.2;</pre></blockquote>
<h2 data-scrollto="ssl3">SSL 3.0</h2>
<p>SSL 3.0 was deprecated in June 2015 and is considered insecure as it is vulnerable to the POODLE attack.</p>
<h3>Removal steps</h3>
<h4>Apache</h4>
<blockquote><pre>SSLProtocol All -SSLv2 -SSLv3</pre></blockquote>
<h4>IIS</h4>
<p>Disabling SSL 3.0 in IIS requires registry edits. Follow the following Microsoft guide for steps: <a href="https://support.microsoft.com/en-us/kb/187498">https://support.microsoft.com/en-us/kb/187498</a></p>
<h4>nginx</h4>
<blockquote><pre>ssl_protocols TLSv1 TLSv1.1 TLSv1.2;</pre></blockquote>
<h4>References</h4>
<p><a href="https://www.openssl.org/~bodo/ssl-poodle.pdf">https://www.openssl.org/~bodo/ssl-poodle.pdf</a></p>
<h2 data-scrollto="tls1">TLS 1.0</h2>
<p>TLS 1.0 is considered insecure as it is vulnerable to the POODLE attack. It can also no longer be used after June 30, 2016 if you want to be PCI Compliant. You may still need to provide TLS 1.0 if your target users are running older browsers.</p>
<h3>Removal steps</h3>
<h4>Apache</h4>
<blockquote><pre>SSLProtocol all -SSLv3 -TLSv1</pre></blockquote>
<h4>IIS</h4>
<p>Disabling SSL TLS 1.0 in IIS requires registry edits. Follow the following Microsoft guide for steps: <a href="https://support.microsoft.com/en-us/kb/187498">https://support.microsoft.com/en-us/kb/187498</a></p>
<h4>nginx</h4>
<blockquote><pre>ssl_protocols TLSv1.1 TLSv1.2;</pre></blockquote>
<h2 data-scrollto="tls11">TLS 1.1</h2>
<p>TLS 1.1 is the second most recent version of TLS. It fixes some security problems in TLS 1.0, removing the need for many of the workarounds built into clients and servers.</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>SSLProtocol all -SSLv3 -TLSv1</pre></blockquote>
<h4>IIS</h4>
<p>TLS 1.1 is enabled by default on Windows Server 2012. To enable it in Windows Server 2008 R2 see the following guide: <a href="http://tecadmin.net/enable-tls-on-windows-server-and-iis/">http://tecadmin.net/enable-tls-on-windows-server-and-iis/</a></p>
<h4>nginx</h4>	
<blockquote><pre>ssl_protocols TLSv1.1 TLSv1.2;</pre></blockquote>
<h2 data-scrollto="tls12">TLS 1.2</h2>
<p>TLS 1.2 is latest version of TLS. TLS 1.2 provides access to advanced cipher suites that support elliptical curve cryptography (large efficiency wins) and AEAD block cipher modes (like the very nice GCM cipher suites).</p>
<h3>Setup</h3>
<h4>Apache</h4>
<blockquote><pre>SSLProtocol all -SSLv3 -TLSv1 -TLSv1.1</pre></blockquote>
<h4>IIS</h4>
<p>TLS 1.2 is enabled by default on Windows Server 2012. To enable it in Windows Server 2008 R2 see the following guide: <a href="http://tecadmin.net/enable-tls-on-windows-server-and-iis/">http://tecadmin.net/enable-tls-on-windows-server-and-iis/</a></p>
<h4>nginx</h4>	
<blockquote><pre>ssl_protocols TLSv1.2;</pre></blockquote>
<h4>References</h4>
<p><a href="https://www.howsmyssl.com/s/about.html">https://www.howsmyssl.com/s/about.html</a></p>