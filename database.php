<?php
global $link;

class DB
{

function __construct($host,$database,$user,$pass)
{
	$link= mysqli_connect($host,$user,$pass,$database);
	$this->link = $link;
	if (!$this->link)
    {
        die('DB Error');
    }

}

function __destruct()
{
    mysqli_close($this->link);
}


function setMode($id)
{
    $id = mysqli_escape_string($this->link,$id);
    if (!$id)
    {
        return false;
    }
    $sql = 'update modes set active = 0';
    if (!mysqli_query($this->link, $sql))
    {
        return false;
    }
    $sql = "update modes set active = 1 where id = $id";
    return mysqli_query($this->link, $sql);
}

function resetQueue()
{
    $sql = "truncate table queue";
    return mysqli_query($this->link, $sql);
}

function deleteAllSongs($type=NULL)
{
    if ($type && $type != "all")
    {
        $type = mysqli_escape_string($this->link,$type);
        $sql = "delete from songs where type = $type";
    }else
    {
        $sql = 'truncate songs';
    }
    return mysqli_query($this->link, $sql);
}


function getMode()
{
    $sql = 'select * from modes where active = 1';
    $arr = $this->arrayQuery($sql);
    return $arr[0];
}

function getTotalSongs()
{
    $sql = 'select count(*) from songs';
    $arr = $this->arrayQuery($sql);
    return $arr[0][0];
}

function getQueueSize()
{
    $sql = 'select count(*) from queue';
    $arr = $this->arrayQuery($sql);
    return $arr[0][0];
}

function getQueue()
{
    $sql = "select queue.id, queue.user, songs.artist, songs.title, songs.code, songs.track from queue, songs where queue.song_id = songs.id order by queue.id asc";
    return $this->arrayQuery($sql);
}

function deleteFromQueue($id)
{
    $id = mysqli_escape_string($this->link,$id);
    $sql = "delete from queue where id = $id";
    return mysqli_query($this->link, $sql);
}

function addToQueue($id, $name)
{
    $id = mysqli_escape_string($this->link,$id);
    $name = mysqli_escape_string($this->link,$name);
    $this->increaseCount($id);
    $sql = "insert into queue (song_id, user) values ($id, '$name')";
    echo $sql;
    return mysqli_query($this->link, $sql);
}

function increaseCount($id)
{
    $id = mysqli_escape_string($this->link,$id);
    $sql = "update songs set count = count+1 where id = $id";
    return mysqli_query($this->link, $sql);
}

function search($name)
{
    $mode = $this->getMode();
    $name = mysqli_escape_string($this->link,$name);
    $sql = "select * from songs where type = 1 and (( title COLLATE UTF8_GENERAL_CI LIKE '".$name."' ) or ( artist COLLATE UTF8_GENERAL_CI LIKE '".$name."' )) limit 0, 100";
    return $this->arrayQuery($sql);
}

function addSong($type,$artist,$title,$code,$track)
{
    $type = mysqli_escape_string($this->link,$type);
    $artist = mysqli_escape_string($this->link,$artist);
    $title = mysqli_escape_string($this->link,$title);
    $code = mysqli_escape_string($this->link,$code);
    $track = mysqli_escape_string($this->link,$track);

    $sql = "INSERT into songs (type,artist,title,code,track) values ($type,'$artist','$title','$code',$track)";

    return mysqli_query($this->link, $sql);
}

function getModes()
{
    $sql = 'SELECT * from modes order by active';
    return $this->arrayQuery($sql);
}


private function arrayQuery($sql)
{
    $result = mysqli_query($this->link, $sql);
    if (!$result)
    {
        return;
    }
    $out = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH))
    {
        $out[] = $row;
               
    }
				
    return $out;
}


}
?>
