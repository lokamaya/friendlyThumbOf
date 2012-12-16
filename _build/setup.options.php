<?php
/**
 * Build the setup options form.
 *
 * @package catalogues
 * @subpackage build
 */
/* set some default values */

/* get values based on mode */
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output = '<h2>friendlyThumbOf Installer</h2>
        <p>Generate friendly url for phpThumbOf</p>
        <br />
        <p><strong>Requirement:</strong></p>
        <p>
          - phpThumbOf (not included and must be installed separately)<br />
          - Apache mod_rewrite (.htaccess sample can be found in doc folder)
        </p>
        <p>Thank for using friendlyThubOf</p><br />';
        break;
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;