<?php
/**
 * Parsimony
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@parsimony-cms.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Parsimony to newer
 * versions in the future. If you wish to customize Parsimony for your
 * needs please refer to http://www.parsimony.mobi for more information.
 *
 * @authors Julien Gras et Benoît Lorillot
 * @copyright Julien Gras et Benoît Lorillot
 * 
 * @category Parsimony
 * @package admin
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

$dirPath = \app::$request->getParam('dirPath');
$dirPath = str_replace('..', '', $dirPath); /* securize path */

echo '<div id="path">' . $dirPath . '</div><div id="dirsandfiles">';

$array_img = array('.jpeg', '.png', '.gif', '.jpg');
$extOk = array();
if($_SESSION['permissions'] & 2048) { /* perm 2048 = Restrict file operations to medias */
	$extOk = $array_img;
}
$extKo = array('.obj');
if(empty($dirPath)){
	$files = glob(PROFILE_PATH . '*');
} else {
	$files = glob(PROFILE_PATH . $dirPath . '/*');
}
$newfilename = '';
foreach ((is_array($files) ? $files : array()) as $filename) :
	$path = str_replace(PROFILE_PATH, '', $filename);
	if (is_dir($filename)) : ?>
		<div class="explorer_file dir" path="<?php echo $path; ?>" data-title="<?php echo basename($filename) ?>">
			<div class="del"><span class="delete ui-icon ui-icon-closethick"></span></div>
		</div>
		<?php
		elseif ((empty($extOk) || in_array(strrchr($filename, '.'), $extOk)) &&
			(empty($extKo) || !in_array(strrchr($filename, '.'), $extKo))) :
		?>
		<?php if (in_array(strrchr($filename, '.'), $array_img)) : ?>
		<div class="explorer_file" path="<?php echo $path; ?>" data-title="<?php echo basename($filename) ?>">
				<img src="<?php echo BASE_PATH . $path; ?>?x=55&y=55" > 
		<?php else: ?>
		<div class="explorer_file file" path="<?php echo $path; ?>" data-title="<?php echo basename($filename) ?>">
		 <?php endif; ?>
		<div class="del"><span class="delete ui-icon ui-icon-closethick"></span></div>
	</div>
	<?php
	endif;
endforeach;
?>
<div class="explorer_new new">
	<div>+</div>	New 
</div>
</div>
