<div class="m-menu">
    <dl class="site-nav">
        <?
        $second_id=substr($class_id,0,6);
        $tid=substr($class_id,0,3);
        if ($menu == "contact"){
            $sql = "select id, name from dept order by sortnum asc";
            $rst = $db->query($sql);
            while ($row = $db->fetch_array($rst)){
        ?>
        <dt><a href="<?=$menu?>.php?dept_id=<?=$row["id"]?>"<?if ($dept_id == $row["id"]) echo " class='current'"?>><?=$row["name"]?></a></dt>
        <?
            }
        }elseif ($menu == "search"){
        ?>
        <dt><a href="<?=$menu?>.php"><?=$base_name?></a></dt>
        <?
        }else{
        ?>
        <?
            $db2    = new onlyDB($config["db_host"], $config["db_user"], $config["db_pass"], $config["db_name"]);
            $sql = "select * from info_class where id like '" . $base_id . "___'  order by sortnum asc";
            $rst = $db->query($sql);
            while ($row = $db->fetch_array($rst)){
        ?>
            <dt><a href="info.php?class_id=<?=$row["id"]?>"<? if($row["id"]==$second_id) echo " class='current'"?>><?=$row["name"]?></a></dt>
            <?
            if($row['has_sub']==1){
                $sql2 = "select id, name from info_class where id  like '".$row["id"]."___' order by sortnum asc";
                $rst2 = $db2->query($sql2);
                while ($row2 = $db2->fetch_array($rst2)){
            ?>
                 <dd><a href="info.php?class_id=<?=$row2["id"]?>"<?if ($sub_class == $row2["id"]) echo " class='current'"?>><?=$row2["name"]?></a></dt>
            <?
                }
            }
            ?>
        <?
            }
        }
        ?>
    </dl>
</div>