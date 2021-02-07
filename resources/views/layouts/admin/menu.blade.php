<?php
use Helpers\MenuHelper;
?>
<div class="col-md-2">
      <div class="card">
          <div class="card-header"><i class="fas fa-th-list"></i></i> MENU</div>
          <div class="card-body">
              <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked list-group" style="display:block;">
                    <a href="{{ route('admin.orders') }}"><li class="{{ MenuHelper::getClass('admin.orders') }}">注文管理</li></a>
                    <a href="{{ route('admin.items') }}"><li class="{{ MenuHelper::getClass('admin.items') }}">商品管理</li></a>
                </ul>
              </div>
          </div>
      </div>
  </div>
