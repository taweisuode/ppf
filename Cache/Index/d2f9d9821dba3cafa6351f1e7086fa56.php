<html>
<head>
<title><?php echo $this->value['result'];?></title>
</head>
<body>
<?php if($max == 4){ ?>
aaa
<?php }else if( $max == 6){ ?>
asaas
<?php }else{ ?>
ccc
<?php }?>
<table>
<?php foreach($this->value['fruit'] as $key => $val){?>
<tr>
    <td><?php echo $key; ?></td><td><?php echo $val; ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>
