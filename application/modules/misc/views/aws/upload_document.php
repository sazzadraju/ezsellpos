<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
    <p>Type: 
        <select name='doc_type' id='doc_type'>
            <?php foreach($types as $type):?>
            <option value="<?php echo $type;?>"><?php echo ucfirst($type);?></option>
            <?php endforeach;?>
        </select>
    </p>
    <p>File: <input type="file" name="file" id="file"></p>
    <p><input type="submit" value="Upload"></p>
</form>
    <hr>
    <p>File Size: <?php echo $file_size;?></p>
    <hr>
    
    <?php if(isset($aws_s3_url)){
        pa($aws_s3_url);
    }?>
    
</body>
</html>