<script src=bootstrap.js?t=1536591797></script>
<?php echo $this->value['data']; ?>,<?php echo $this->value['person']; ?>
<ul>
    <?php foreach ((array)$this->value['b'] as $K => $V) { ?>
        <li><?php echo $V; ?></li><?php } ?>
</ul>
<?php
echo '这里是php原生代码',$data1*2,"<br/>";
?>
<?php if ($data === 'a') { ?>
    成功
<?php }else if ($data === 'b') { ?>
    失败
<?php }else{ ?>
    我最厉害<?php echo $this->value['data']; ?>
<?php } ?>
