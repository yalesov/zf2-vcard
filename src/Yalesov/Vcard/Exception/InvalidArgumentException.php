<?php
namespace Yalesov\Vcard\Exception;

use Yalesov\Vcard\ExceptionInterface;

/**
 * InvalidArgumentException
 *
 * @author yalesov <yalesov@cogito-lab.com>
 * @license GPL http://opensource.org/licenses/gpl-license.php
 */
class InvalidArgumentException
  extends \InvalidArgumentException
  implements ExceptionInterface
{
}
