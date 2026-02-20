<?php include_once("./views/templates/document-start.php");?>


<div class="p-5 bg-light">
    <div class="container">
        <h1 class="display-3">Hola Adeline</h1>
        <hr class="my-2">        
    </div>
</div>


    <div class="row">
        <div class="col-md-3 offset-md-2 ">
            <div class="card">
                <a href="<?php PATHSERVER;?>user/showAll">
                    <img src="https://picsum.photos/300/301"  alt="">
                    <h4 >User Management</h4>
                </a>
            </div>   
        </div>
        <div class="col-md-3">
            <div class="card">
                <a href="">
                    <img src="https://picsum.photos/299/300"  alt="">
                    <h4 >Games Management</h4>
                </a>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-3 offset-md-2 ">
            <div class="card">
                <a href="">
                    <img src="https://picsum.photos/300/300"  alt="">
                    <h4 >Media Management</h4>
                </a>
            </div>   
        </div>
        <div class="col-md-3">
            <div class="card">
                <a href="">
                    <img src="https://picsum.photos/301/300"  alt="">
                    <h4 >other Management</h4>
                 </a>
            </div>
        </div>
    </div>


<?php include_once("./views/templates/document-end.php");?>