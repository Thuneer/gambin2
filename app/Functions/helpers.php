<?php


function userAvatar($id) {

    $path = '';

    if ($id % 7 == 0)
        $path = '/img/avatars/avatar1.png';
    else if($id % 6 == 0)
        $path = '/img/avatars/avatar2.png';
    else if($id % 5 == 0)
        $path = '/img/avatars/avatar3.png';
    else if($id % 4 == 0)
        $path = '/img/avatars/avatar4.png';
    else if($id % 3 == 0)
        $path = '/img/avatars/avatar5.png';
    else if($id % 2 == 0)
        $path = '/img/avatars/avatar6.png';
    else if($id % 1 == 0)
        $path = '/img/avatars/avatar7.png';

    return $path;

}