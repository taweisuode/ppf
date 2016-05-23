<html>
<head>
<title><?php echo $this->value['add'];?></title>
</head>
<body>
<?php echo $this->value['add'];?>
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
