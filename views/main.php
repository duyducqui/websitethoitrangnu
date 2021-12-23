<style>
    .c:hover {
        width: 100%;
        height: 50px;
    }

    .vidu2 {
        text-decoration: line-through;
    }
</style>
<div class="container text-center" style="margin-top:15px;">
    <h3>Các Ưu Đãi <span class="badge badge-secondary">Mới</span></h3>
    <br>
    <div class="row">
        <?php
        foreach ($xem['product'] as $k => $v) {
            $t = $v["price"] - $v["discount"]
        ?>
            <div class="col-sm-4">
                <a href="?url1=chitiet&&id=<?php echo $v['id']; ?>"><img src="image/<?php echo $v["image_link"]; ?>" class="img-responsive" style="width:100%;height: 350px;" alt="Image"></a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $v["name"]; ?></h5>
                    <p class="vidu2">Giá Củ: <?php echo $v["price"]; ?> vnd</p> 
                    <p>Giá Mới: <?php echo $t; ?> vnd</p>
                    <a href="#" class="btn btn-primary c">Thêm Vào Giỏ</a>
                </div>
            </div>
        <?php
        } ?>
    </div>
</div>
</div>
</div>
</div>