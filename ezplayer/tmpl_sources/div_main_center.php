<?php
/*
 * EZCAST EZplayer
 *
 * Copyright (C) 2014 Université libre de Bruxelles
 *
 * Written by Michel Jansens <mjansens@ulb.ac.be>
 * 	      Arnaud Wijns <awijns@ulb.ac.be>
 *            Carlos Avidmadjessi
 * UI Design by Julien Di Pietrantonio
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this software; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
?>

<script>
    lvl = 1;
</script>
<?php
include_once 'lib_print.php';
global $ezplayer_url;
global $ezmanager_url;
?> 
<div class="search_wrapper">
    <div id="search">
        <?php include_once template_getpath('div_search.php'); ?>
    </div>
</div>

<div class="albums">
    <?php
    if (!isset($albums) || sizeof($albums) == 0) {
        ?>
        <span>®No_consulted_album®</span>
        <?php
    } else {
        ?>
        <!--a class="album_options_button" href="javascript:toggle('.album_options');"></a-->
        <ul>
            <?php
            foreach ($albums as $index => $album) {
                $player_full_url = $ezplayer_url . "?action=view_album_assets&album=" . $album['album'] . "&token=" . $album['token'];
                $ezplayer_rss_url = $ezmanager_url . "/distribute.php?action=rss&album=" . $album['album'] . "&quality=ezplayer&token=" . $album['token'];
                include template_getpath('popup_player_url.php');
                include template_getpath('popup_rss_feed.php');
                $private = false;
                if (suffix_get($album['album']) == '-priv')
                    $private = true;
                ?>
                <li>    
                    <a class="item <?php if ($private) echo 'private' ?>" href="javascript:show_album_assets('<?php echo $album['album']; ?>', '<?php echo $album['token']; ?>');">
                        <b style="text-transform:uppercase;"><?php echo suffix_remove($album['album']); ?></b> 
                        <?php if ($private) echo '(®Private_album®)' ?>
                        <br/><?php print_info($album['title']); ?>

                    </a>
                </li>
                <?php if (acl_user_is_logged()) { ?>
                    <div class="album_options left">
                        <a class="up-arrow" <?php if ($index == 0) { ?>style="visibility:hidden"<?php } ?> href="javascript:move_album_token(<?php echo $index; ?>, 'up');" title="®Move_up®"></a>
                        <?php if ($index != count($albums) - 1) { ?><a class="down-arrow" href="javascript:move_album_token(<?php echo $index; ?>, 'down');" title="®Move_down®"></a><?php } ?>
                    </div>
                    <?php
                    if (acl_user_is_logged() && acl_show_notifications()) {
                        $count = acl_global_count($album['album']);
                        if (($count - acl_watched_count($album['album'])) > 0) {
                            ?>
                            <div class="album_count green" title="<?php print_new_video($count - acl_watched_count($album['album'])); ?>"><?php echo ($count - acl_watched_count($album['album'])); ?></div>
                            <?php
                        }
                    }
                    ?> 

                    <div class="album_options pull-right inline-block">
                        <?php if (acl_has_album_moderation($album['album']) || acl_is_admin()) { ?>
                            <a  href="#" class="button-rect green pull-right inline-block share-album" data-reveal-id="popup_share_album_<?php echo $album['album'] ?>">®share_album®</a>
                        <?php } ?>
                        <a  href="#" class="button-rect green pull-right inline-block share-rss" data-reveal-id="popup_share_rss_<?php echo $album['album'] ?>">®subscribe_rss®</a>
                        <?php if (suffix_get($album['album']) == '-priv' || !acl_has_album_moderation($album['album'])) { ?> 
                            <a class="delete-album" title="®Delete_album®" href="#" data-reveal-id="popup_delete_album_<?php echo $index ?>"></a>
                        <?php } ?>
                    </div>

                                    <!--span class="delete_album" onclick="delete_album_token('<?php echo $album['album']; ?>');">x</span-->
                    <?php
                    include template_getpath('popup_delete_album.php');
                }
            }
            ?>
        </ul>
        <?php
    }
    ?>
</div>