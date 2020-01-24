<?php

//This is variable is an example - Just make sure that the urls in the 'idp' config are ok.

return $settings = array(

    /**
     * If 'useRoutes' is set to true, the package defines five new routes:
     *
     *    Method | URI                      | Name
     *    -------|--------------------------|------------------
     *    POST   | {routesPrefix}/acs       | saml_acs
     *    GET    | {routesPrefix}/login     | saml_login
     *    GET    | {routesPrefix}/logout    | saml_logout
     *    GET    | {routesPrefix}/metadata  | saml_metadata
     *    GET    | {routesPrefix}/sls       | saml_sls
     */
    'useRoutes' => true,

    'routesPrefix' => '/saml2',

    /**
     * which middleware group to use for the saml routes
     * Laravel 5.2 will need a group which includes StartSession
     */
    'routesMiddleware' => ['web'],

    /**
     * Indicates how the parameters will be
     * retrieved from the sls request for signature validation
     */
    'retrieveParametersFromServer' => false,

    /**
     * Where to redirect after logout
     */
    'logoutRoute' => '/',

    /**
     * Where to redirect after login if no other option was provided
     */
    'loginRoute' => '/loggedin',


    /**
     * Where to redirect after login if no other option was provided
     */
    'errorRoute' => '/error',




    /*****
     * One Login Settings
     */



    // If 'strict' is True, then the PHP Toolkit will reject unsigned
    // or unencrypted messages if it expects them signed or encrypted
    // Also will reject the messages if not strictly follow the SAML
    // standard: Destination, NameId, Conditions ... are validated too.
    'strict' => false, //@todo: make this depend on laravel config

    // Enable debug mode (to print errors)
    'debug' => true, //@todo: make this depend on laravel config

    // Service Provider Data that we are deploying
    'sp' => array(

        // Specifies constraints on the name identifier to be used to
        // represent the requested subject.
        // Take a look on lib/Saml2/Constants.php to see the NameIdFormat supported
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',

        // Usually x509cert and privateKey of the SP are provided by files placed at
        // the certs folder. But we can also provide them with the following parameters
        'x509cert' => 'MIIECzCCAvKgAwIBAgIBADANBgkqhkiG9w0BAQsFADCBnjELMAkGA1UEBhMCcnUx
GTAXBgNVBAgMEFNhaW50IFBldGVyc2J1cmcxDzANBgNVBAoMBlJVTk5ldDEkMCIG
A1UEAwwbaHR0cDovLzg1LjE0Mi4yOS4xMS9tb25pdG9yMRkwFwYDVQQHDBBTYWlu
dCBQZXRlcnNidXJnMSIwIAYJKoZIhvcNAQkBFhNwb3JoYWNoZXZAcnVubmV0LnJ1
MB4XDTIwMDExNjA5NTYxOVoXDTIxMDExNTA5NTYxOVowgZ4xCzAJBgNVBAYTAnJ1
MRkwFwYDVQQIDBBTYWludCBQZXRlcnNidXJnMQ8wDQYDVQQKDAZSVU5OZXQxJDAi
BgNVBAMMG2h0dHA6Ly84NS4xNDIuMjkuMTEvbW9uaXRvcjEZMBcGA1UEBwwQU2Fp
bnQgUGV0ZXJzYnVyZzEiMCAGCSqGSIb3DQEJARYTcG9yaGFjaGV2QHJ1bm5ldC5y
dTCCASMwDQYJKoZIhvcNAQEBBQADggEQADCCAQsCggECANEOKSEbIeE4jM1e46uP
DCFWs2WUd+fHGjcR//9rN1Y0iHAKCmaUq4Pg5wBYBpBNUVy0rVtFV3hEKr2quWQL
KBM8/dl0VmUWMHp2nTgfY/jRPeKQPpWyFDyxJiZ1gsfc3c8e13thFxgrjceddQf/
iWlQ32Ve2phALAzHvuikeiak8HOpft8A/N0dPK+7j+X49M9vhAj9zNiWzMjMC19N
vZ2H4KQb1ilebWpL0H1OKUXxTaNpZh/wYdATBkQ23DBeX56z3U0OrLjM5fAMm57S
Enw+JmK4CstOPdipnuSAJ+X0/MKxzp7i+HAwSZPJM35i1bdQjsiRb8Fw/g0tmyYh
mHyjAgMBAAGjUDBOMB0GA1UdDgQWBBRspDg2mRixyTGEVcmECEPVG1eeATAfBgNV
HSMEGDAWgBRspDg2mRixyTGEVcmECEPVG1eeATAMBgNVHRMEBTADAQH/MA0GCSqG
SIb3DQEBCwUAA4IBAgAxDrEtDW4uC4jX3/XrFQFI3wmIn2LnZmDNFjn+OD40vm/p
TmpFJsNHYLhWbT0vEmzMQ/gYI2Ms7F+OIiNsWiMB6tl/UpgQ9066kPXamNuiQtFt
cflxPe1AkXPFW9YWh9tJKCsgYFyr2EZI58c3aUWJVDEITyYTXd9ecHB22dHdFRJ3
qcgzRPQtkcEwasSXypJxA0UUTsCJvg7l6asu3mkKBGQ4nF7onMQdT/btjWMsW6N3
u9iXOAgPzozODdjjFoyHmuc5F57Ej/4K58wcEfeWa9PdexOzF9hIpL3MxDlgpLQ/
sjqK8bqEoRfXz/Wtg7Esf5fu0EMbAoRaOcduwGJ64Q==',

        'privateKey' => 'MIIEwQIBADANBgkqhkiG9w0BAQEFAASCBKswggSnAgEAAoIBAgDRDikhGyHhOIzN
XuOrjwwhVrNllHfnxxo3Ef//azdWNIhwCgpmlKuD4OcAWAaQTVFctK1bRVd4RCq9
qrlkCygTPP3ZdFZlFjB6dp04H2P40T3ikD6VshQ8sSYmdYLH3N3PHtd7YRcYK43H
nXUH/4lpUN9lXtqYQCwMx77opHompPBzqX7fAPzdHTyvu4/l+PTPb4QI/czYlszI
zAtfTb2dh+CkG9YpXm1qS9B9TilF8U2jaWYf8GHQEwZENtwwXl+es91NDqy4zOXw
DJue0hJ8PiZiuArLTj3YqZ7kgCfl9PzCsc6e4vhwMEmTyTN+YtW3UI7IkW/BcP4N
LZsmIZh8owIDAQABAoIBAXzj6M5OVz8leXh3Z6vmGWkRUrsspzVgTNj5d+YvNy/Y
0mmclfoSdySiB169N66dgi3QAoC0PD0s/BuzEm4h/B8CIOT4C2T4jJ2cnvAYULEk
z8O6SKlFabGYYyI2sZqU6C4ETtb2ecWGv3yxJGlSz9SK6+qzcAPk0mwQKIzzNcZA
Ud2il4+w/wj766bcIAU8jxgW1yWtgSpEphEGciPfqdzitPZimT0agbREtu0QNoj8
ERZ8BMStPqDRVCGXi1BujcoDa5j7078/JdESjD/fj4ZoFLomeytB+ovFWndaNaro
adWgc3CeqziFL4J1hiBM5u72ktKrCGz/YQVqh3jSVJ0BAoGBDtmHJ0cUxE+sJXSw
AgJjQwWMhGdOJ/pd/BW8X7MEONk/E1GcCDMdaKRDNjAiyWKqlB8Qr02/FceYoLfD
kZhT7qheCFLqZb7i6aecsSZPPt4eXcF38PVrF2ygRg57le8hWw72FZSFN4qXYK1+
HsW3D16NZwPPQjk40Dphcp0opq55AoGBDhP8H2YRk+xc+Uqv3S4zHblReuTszP2R
vP6DdkAZuRkm5M1FbiJGDFBmr4b5+KymEgHNZOaUdAKD4nF8uitHPGNW12gmtHBS
kf1fFwWrAPuaUrX+/moLfqEu3TL+GnUCJ9XFf2OXbNd4oove2ZL9HsagnqihXCOh
cAPkczXXe8z7AoGBCtcdZLztGgoXXxh5zF213J1WYOmREnog1f+ADlR+xolBFHdE
8m9uDo+rSQmGu4C9iXfMFE0rK1kTwG+l4slSrCxYyLbOygu5Vly3dFLFEt3PSR4M
0ug1j1oK/llgOqngrbqURlivj0YrD7ZXFVu8MQoTK5qKWIuxP8D+lk7H+DXxAoGB
CmwHGSOR3cV8qtz8xqw+EUIxLN6u467Qpm5w2ijoIhyZq4a/YKIk41bePhGZmtwN
cYU+DfWZbyyxgADuClChwvXzwzIKfUguCH/fVobOqsKY46RyKtxMuCkRLZZjgSig
OOdL91u+LUhyuTr89muX0aHQJMTH+BM0n11yUUxJww/jAoGBCLWCtuBa+WT2C4jH
HqI8IcaW2yTQBV1IwzNAqtOiRCLW1D+KG/aCZpehKg7vWk4v2dLAVE1a/dRVd0u/
gg1P58VtyCDrsOqAA5suC1+FOY4BbKfQbBPqgdJHt/wrD8lAyCkUSwocdXBBMHKW
guRu/Vq3xhaIgJRmywKv4CaBxqbV',

        // Identifier (URI) of the SP entity.
        // Leave blank to use the 'saml_metadata' route.
        'entityId' => '',

        // Specifies info about where and how the <AuthnResponse> message MUST be
        // returned to the requester, in this case our SP.
        'assertionConsumerService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-POST binding.
            // Leave blank to use the 'saml_acs' route
            'url' => '',
        ),
        // Specifies info about where and how the <Logout Response> message MUST be
        // returned to the requester, in this case our SP.
        'singleLogoutService' => array(
            // URL Location where the <Response> from the IdP will be returned,
            // using HTTP-Redirect binding.
            // Leave blank to use the 'saml_sls' route
            'url' => '',
        ),
    ),

    'idpNames' => ['runnet'],
    // Identity Provider Data that we want connect with our SP
    'idp' => array(
        // Identifier of the IdP entity  (must be a URI)

        'entityId' => 'https://idp-01.runnet.ru/saml/saml2/idp/metadata.php',
        // SSO endpoint info of the IdP. (Authentication Request protocol)
        'singleSignOnService' => array(
            // URL Target of the IdP where the SP will send the Authentication Request Message,
            // using HTTP-Redirect binding.

            'url' => "https://idp-01.runnet.ru/saml/saml2/idp/SSOService.php",
        ),
        // SLO endpoint info of the IdP.
        'singleLogoutService' => array(
            // URL Location of the IdP where the SP will send the SLO Request,
            // using HTTP-Redirect binding.

            'url' => 'https://idp-01.runnet.ru/saml/saml2/idp/SingleLogoutService.php',
        ),
        // Public x509 certificate of the IdP

        'x509cert' => 'MIID7zCCAtagAwIBAgIBADANBgkqhkiG9w0BAQ0FADCBkDELMAkGA1UEBhMCcnUx GDAWBgNVBAgMD1Nhbmt0LVBldGVyYnVyZzEPMA0GA1UECgwGUlVOTmV0MRkwFwYD VQQDDBBpZHAtMDEucnVubmV0LnJ1MRgwFgYDVQQHDA9TYW5rdC1QZXRlcmJ1cmcx ITAfBgkqhkiG9w0BCQEWEnZhc2lseWV2QHJ1bm5ldC5ydTAeFw0xODAzMTIwNzQy MDBaFw00MDA0MjUwNzQyMDBaMIGQMQswCQYDVQQGEwJydTEYMBYGA1UECAwPU2Fu a3QtUGV0ZXJidXJnMQ8wDQYDVQQKDAZSVU5OZXQxGTAXBgNVBAMMEGlkcC0wMS5y dW5uZXQucnUxGDAWBgNVBAcMD1Nhbmt0LVBldGVyYnVyZzEhMB8GCSqGSIb3DQEJ ARYSdmFzaWx5ZXZAcnVubmV0LnJ1MIIBIzANBgkqhkiG9w0BAQEFAAOCARAAMIIB CwKCAQIAzU09LXZcMusVKmQHLcUWzAQQyYbcJNa6mqAsQB43WjUGCqv6ChkMB/vl MePnMFdjrpWs4HNKrC0GN8cdWkJ3hnYyvxmKCAP8k0cHg4j+Zt5QWrAGOzNYidJQ xPmoCNqk3SGGT8opvs0IjOfQWSxP0MI5JXDNVvTvu8jHezCuXyRC4pbHn4PjY7/6 NHhcksELHDvlrvWrjC+GGIlt3YvNvaDrCUBIBM9/5XCczOA/9/IxNSV5zz4scd12 tuzRtwgel0JCbqUbgDwQtxiP+9AR2uUJI+IBwO6zmWxfwmqWuqlPvrcguaO/Av1c nHwbgay9hxIdMKdj8s19kjbEgtxDQpECAwEAAaNQME4wHQYDVR0OBBYEFBNOea1J HeJe4YESUmuy54D3SpeFMB8GA1UdIwQYMBaAFBNOea1JHeJe4YESUmuy54D3SpeF MAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQENBQADggECAGAeqn0gBFNqZN9CgxKB Q6tWzJCOzLJ0r4L/IAKnfEgbm8YEc1kK+6fk79UEpawMKIrBeSoH05RzOBATTe3A R0kDFBbkloDQw7eLdo3il6ypN3Zhs9opl3EJUe9IQOscy1Jdjnz1ZsoogNDJ2iCl idBZzl3hShKf2XzgT4DL+P7GRahrAfhDBWwL9650DkDEYMwItBYJb4Hh+wXH10CQ LfzonFW7jUbo/q8hb6NuCs0SePcXFg93RXVzvU3DEYnp6oDAaoe165w45x1XnbC4 y0fH4+Ryxi7uLwk6A3ArdicAEtmc6Pk92MjtDRCOJ6IepKEPYbKTOfGyl+4yftfG UNNk',
        /*
         *  Instead of use the whole x509cert you can use a fingerprint
         *  (openssl x509 -noout -fingerprint -in "idp.crt" to generate it)
         */
        // 'certFingerprint' => '',
    ),



    /***
     *
     *  OneLogin advanced settings
     *
     *
     */
    // Security settings
    'security' => array(

        /** signatures and encryptions offered */

        // Indicates that the nameID of the <samlp:logoutRequest> sent by this SP
        // will be encrypted.
        'nameIdEncrypted' => false,

        // Indicates whether the <samlp:AuthnRequest> messages sent by this SP
        // will be signed.              [The Metadata of the SP will offer this info]
        'authnRequestsSigned' => false,

        // Indicates whether the <samlp:logoutRequest> messages sent by this SP
        // will be signed.
        'logoutRequestSigned' => false,

        // Indicates whether the <samlp:logoutResponse> messages sent by this SP
        // will be signed.
        'logoutResponseSigned' => false,

        /* Sign the Metadata
         False || True (use sp certs) || array (
                                                    keyFileName => 'metadata.key',
                                                    certFileName => 'metadata.crt'
                                                )
        */
        'signMetadata' => false,


        /** signatures and encryptions required **/

        // Indicates a requirement for the <samlp:Response>, <samlp:LogoutRequest> and
        // <samlp:LogoutResponse> elements received by this SP to be signed.
        'wantMessagesSigned' => false,

        // Indicates a requirement for the <saml:Assertion> elements received by
        // this SP to be signed.        [The Metadata of the SP will offer this info]
        'wantAssertionsSigned' => false,

        // Indicates a requirement for the NameID received by
        // this SP to be encrypted.
        'wantNameIdEncrypted' => false,

        // Authentication context.
        // Set to false and no AuthContext will be sent in the AuthNRequest,
        // Set true or don't present thi parameter and you will get an AuthContext 'exact' 'urn:oasis:names:tc:SAML:2.0:ac:classes:PasswordProtectedTransport'
        // Set an array with the possible auth context values: array ('urn:oasis:names:tc:SAML:2.0:ac:classes:Password', 'urn:oasis:names:tc:SAML:2.0:ac:classes:X509'),
        'requestedAuthnContext' => true,
    ),

    // Contact information template, it is recommended to suply a technical and support contacts
    'contactPerson' => array(
        'technical' => array(
            'givenName' => 'name',
            'emailAddress' => 'no@reply.com'
        ),
        'support' => array(
            'givenName' => 'Support',
            'emailAddress' => 'no@reply.com'
        ),
    ),

    // Organization information template, the info in en_US lang is recomended, add more if required
    'organization' => array(
        'en-US' => array(
            'name' => 'Name',
            'displayname' => 'Display Name',
            'url' => 'http://url'
        ),
    ),

    /* Interoperable SAML 2.0 Web Browser SSO Profile [saml2int]   http://saml2int.org/profile/current

       'authnRequestsSigned' => false,    // SP SHOULD NOT sign the <samlp:AuthnRequest>,
                                          // MUST NOT assume that the IdP validates the sign
       'wantAssertionsSigned' => true,
       'wantAssertionsEncrypted' => true, // MUST be enabled if SSL/HTTPs is disabled
       'wantNameIdEncrypted' => false,
    */

);
