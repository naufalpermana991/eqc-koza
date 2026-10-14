<nav class="sidebar">
    <div class="sidebar-header" style="background: white !important;">
        <a href="/" class="sidebar-brand">
            <img style="width: 100px;border-radius: 50px;margin-left: 30px;" src="{{ URL::asset('assets/images/') }}/logo-app.png" alt="">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">MENU</li>
            <?php
            $data_menu = Session::get('logged_menus');
            foreach ($data_menu as $value) { 
                $list_menu = $value->list_menus;
                if(count($list_menu) == 1) {
                    ?>
                    <li class="nav-item">
                        <a href="<?= $list_menu[0]->path ?>" class="nav-link" wire:navigate>
                            <i class="link-icon" data-feather="<?= $list_menu[0]->icon ?>"></i>
                            <span class="link-title"><?= $list_menu[0]->label ?></span>
                        </a>
                    </li>
                    <?php 
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#<?= $value->group ?>" role="button" aria-expanded="false" aria-controls="<?= $value->group ?>">
                            <i class="link-icon" data-feather="<?= $list_menu[0] ?>"></i>
                            <span class="link-title"><?= ucwords(str_replace('_',' ',$value->group)) ?></span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="<?= $value->group ?>">
                            <ul class="nav sub-menu">
                                <?php foreach ($list_menu as $val){ ?>
                                    <li class="nav-item">
                                        <a href="<?= $val->path ?>" class="nav-link" wire:navigate><?= $val->label ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php 
                }
            } 
            ?>
        </ul>
    </div>
</nav>