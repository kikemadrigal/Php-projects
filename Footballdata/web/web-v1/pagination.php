<?php
function pagination($page, $total_pages, $where_name, $where_value, $order_by) {
?>
    <nav class="navbar">
    <ul class="pagination">
        <?php
            $pagina_anterior=$page-1;
            $pagina_actual=$page;
            $pagina_siguiente=$page+1;
            $pagina_siguiente_2=$page+2;
            $pagina_siguiente_3=$page+3;
        ?>
        <!--Anterior-->
        <?php if($page>0) {?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page={$pagina_anterior}&where_name={$where_name}&where_value={$where_value}&order_by={$order_by}"; ?>">Previous</a></li>
        <?php } ?>

        <!-- Actual -->
        <li class="page-item disabled"><a class="page-link" href="#"><?php echo $pagina_actual;?></a></li>
        
        <!--Siguiente -->
        <?php if($pagina_siguiente<$total_pages) {?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page={$pagina_siguiente}&where_name={$where_name}&where_value={$where_value}&order_by={$order_by}"; ?>"><?php echo $pagina_siguiente;?></a></li>
        <?php } ?>

        <!-- Siguiente 2 -->
        <?php if($pagina_siguiente_2<$total_pages) {?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page={$pagina_siguiente_2}&where_name={$where_name}&where_value={$where_value}&order_by={$order_by}"; ?>"><?php echo $pagina_siguiente_2;?></a></li>
        <?php } ?>

        <!-- Siguiente 3 -->
        <?php if($pagina_siguiente_3<$total_pages) {?>
            <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page={$pagina_siguiente_3}&where_name={$where_name}&where_value={$where_value}&order_by={$order_by}"; ?>"><?php echo $pagina_siguiente_3;?></a></li>
        <?php } ?>

        <!--siguiente Next-->
        <?php if($pagina_siguiente<$total_pages) {?>
        <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF']."?page={$pagina_siguiente}&where_name={$where_name}&where_value={$where_value}&order_by={$order_by}"; ?>">Next</a></li>
        <?php } ?>
    </ul>
</nav>
<?php
}
   