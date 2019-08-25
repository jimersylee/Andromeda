{!bootstrap.js!}
{$data},{$person}
<ul>
    {foreach $b}
        <li>{V}</li>{/foreach}
</ul>
<?php
echo '这里是php原生代码',$data1*2,"<br/>";
?>
{if $data === 'a'}
    成功
{elseif $data === 'b'}
    失败
{else}
    我最厉害{$data}
{/if}
{#这里是注释#}