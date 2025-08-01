
<table id="mytable" class="table table-bordred table-striped">
<thead>
 <th class="right_text"><?= lang("invoice_no"); ?></th>
 <th class="right_text"><?= lang("agent-name"); ?></th>
 <th class="right_text"><?= lang("invoice_amount"); ?></th>
 <th class="right_text"><?= lang("delivery_cost"); ?></th>
 <th class="right_text"><?= lang("cod_cost"); ?></th>
</thead>
<tbody>
    <?php
    if (!empty($posts)):
      $total_invoice=0;
      $total_delivery_charge=0;
      $total_cod_charge=0;
        foreach ($posts as $post):
            ?>
            <tr>
                <?php
                echo '<td class="right_text">' .  $post['invoice_no']. '</td>'; 
                echo '<td class="right_text">' .  $post['agent_name']. '</td>';
                echo '<td class="right_text">' .  $post['invoice_total']. '</td>';    
                echo '<td class="right_text">' .  $post['delivery_charge']. '</td>';    
                echo '<td class="right_text">' .  $post['cod_charge']. '</td>';    
               
                ?>
            </tr>
            <?php
            $total_invoice=$total_invoice+$post['invoice_total'];
            $total_delivery_charge=$total_delivery_charge+$post['delivery_charge'];
            $total_cod_charge=$total_cod_charge+$post['cod_charge'];
        endforeach;

        ?>
        <tr>
            <?php 
            
                echo '<td class="right_text" colspan="2" style="font-weight:bold">Total</td>';
                echo '<td class="right_text" style="font-weight:bold">' .  $total_invoice. '</td>';    
                echo '<td class="right_text" style="font-weight:bold">' .  $total_delivery_charge. '</td>';    
                echo '<td class="right_text" style="font-weight:bold">' .  $total_cod_charge. '</td>'; 
             ?>
        </tr>
    <?php else:
        ?>
        <tr>
            <td colspan="5"><b><?= lang("data_not_available");?></b></td>
        </tr>
    <?php endif; ?> 
</tbody>

</table>

<div class="clearfix"></div>
<?php echo $this->ajax_pagination->create_links(); ?>
