
<?php
//$this->set_barcode($temp);
?>
<style>

    .barcode {
        width: 220px;
        text-align: center;
    }
    .no {
        margin-top: -2px;
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 4px;
        color: #000;
    }
</style>

<h1>Barcode</h1>

<?php
for ($i = 1; $i <= 10; $i++) {
    $img = $this->barcode->code128BarCode('1234567898777' . $i, 1);
    //echo'<br>';

    ob_start();
    imagepng($img);
    $output_img = ob_get_clean();
    echo '<div class="barcode">';
    echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '"/>' . '<br>';
    echo '<span class="no"> ' . '1234567898777' . $i . '</span><br />';
    echo '</div>';
}
?>

<br />

