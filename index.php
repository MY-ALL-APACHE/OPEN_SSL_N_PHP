<?php

    $paths=openssl_get_cert_locations();
    $allowed=array("cer","crt","pem");
    if (!empty($paths['ini_capath'])){
        $capathDirectory = dir($paths['ini_capath']);
        while (false !== ($entry = $capathDirectory->read())) {
            $Sourcefile=$paths['ini_capath']."/".$entry;
            if (file_exists( $Sourcefile)){
                $path_parts = pathinfo($Sourcefile);
                if (in_array(strtolower($path_parts['extension']),$allowed)){
                    $ParsedCertificatePbject = openssl_x509_parse(file_get_contents($Sourcefile));
                    $Sourcefile= $ParsedCertificatePbject["hash"].".0";
                    $TargetFilename = dirname($Sourcefile)."/".$Sourcefile;
                    if (!file_exists($TargetFilename)) {
                        rename ($Sourcefile ,$TargetFilename);
                    }
                }
            }
        }
        $capathDirectory->close();
    }

/**
Array
(
    [default_cert_file] => /opt/lampp/share/openssl/cert.pem
    [default_cert_file_env] => SSL_CERT_FILE
    [default_cert_dir] => /opt/lampp/share/openssl/certs
    [default_cert_dir_env] => SSL_CERT_DIR
    [default_private_dir] => /opt/lampp/share/openssl/private
    [default_default_cert_area] => /opt/lampp/share/openssl
    [ini_cafile] => /opt/lampp/share/curl/curl-ca-bundle.crt
    [ini_capath] => 
)
*/


?>


