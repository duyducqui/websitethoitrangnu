<style>
    .v1 {
        text-decoration: line-through;
    }
</style>

<?php


foreach ($xem['product'] as $k => $v) {
    if ($_GET['id'] == $v['id']) {
        $tam = $v['price']- $v['discount'];
?>
        <div class="col-sm-12">
            <h2><?php echo $v['name'];?></h2>
            <div class="fakeimg col-sm-6" style="margin: 5px auto;">
            <img src="image/<?php echo $v["image_link"]; ?>" class="img-responsive" style="width:100%;height: 350px;" alt="Image">
            </div>
            <p>Mô Tả : </p>
            <p><?php echo $v['content']?></p>
            <p class="v1">Giá  Củ: <?php echo $v['price']?></p>
            <h3>Giá Mới : <?php echo $tam?> vnd <span class="badge badge-secondary">-<?php echo $v['discount']?> vnd </span></h3>
            <a href="#" class="btn btn-primary c">Thêm Vào Giỏ</a>
            <br>
        </div>



<?php
    }
}
?>




</div>
</div>
</div>