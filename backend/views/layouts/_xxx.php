    <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>

<?php if (!Yii::$app->user->isGuest): ?>
                <li>
                    <a href="<?= Url::to(['/site/index']); ?>"><i class="fa fa-dashboard active"></i> <span>Dashboard</span></a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span>Data Master</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['/master/orgn']); ?>"><i class="fa fa-check"></i> Orgn</a></li>
                        <li><a href="<?= Url::to(['/master/branch']); ?>"><i class="fa fa-check"></i> Branch</a></li>
                        <li><a href="<?= Url::to(['/master/warehouse/index']); ?>"><i class="fa fa-check"></i> Warehouse</a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-check"></i> Item Master<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/master/product']); ?>"><i class="fa fa-check"></i> Product</a></li>
                                <li><a href="<?= Url::to(['/master/uom']); ?>"><i class="fa fa-check"></i> Uom</a></li>
                                <li><a href="<?= Url::to(['/master/product-group']); ?>"><i class="fa fa-check"></i> Group</a></li>
                                <li><a href="<?= Url::to(['/master/category']); ?>"><i class="fa fa-check"></i> Category</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= Url::to(['/master/customer', 'Vendor[type]' => backend\models\master\Vendor::TYPE_CUSTOMER]); ?>"><i class="fa fa-check"></i> Vendors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart text-orange"></i>
                        <span>Sales & Distribution</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['/sales/sales/create']); ?>"><i class="fa fa-check"></i> Sales Order</a></li>
                        <li><a href="#"><i class="fa fa-check"></i> Sales Return</a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-check"></i> Price Mngnt<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/sales/price-category']); ?>"><i class="fa fa-check"></i> Pricing Category</a></li>
                                <li><a href="<?= Url::to(['/sales/price']); ?>"><i class="fa fa-check"></i> Sales Pricing</a></li>

                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-truck  text-success"></i> <span>Warehouse Mangmnt</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Goods Receipt<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><?= Html::a('<i class="fa fa-check"></i>&nbsp;Receive', ['/inventory/gm-manual', 'GoodsMovement[type]' => backend\models\inventory\GoodsMovement::TYPE_RECEIVE]) ?>
                                    <!--<a href="<?= Url::to(['/inventory/gm-manual', 'type' => \backend\models\inventory\GoodsMovement::TYPE_RECEIVE]); ?>"><i class="fa fa-check"></i> From Supplier</a>-->
                                </li>
                                <li><a href="#"><i class="fa fa-check"></i>&nbsp;Transfer</a></li>
                                <li><a href="#"><i class="fa fa-check"></i>&nbsp;Purchase Return</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Goods Issued <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-check"></i> Surat Jalan</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Mutasi Ke Gdg</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Cancel Issue</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Stock Mangmt<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/inventory/product-stock']); ?>"><i class="fa fa-check"></i> Stocks</a></li>
                                <li><a href="<?= Url::to(['/inventory/stock-history']); ?>"><i class="fa fa-check"></i> Stocks History</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Total Opname</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Stock Adjustment</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-buysellads"></i>
                        <span>FI & Accounting</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= Url::to(['/accounting/coa']); ?>"><i class="fa fa-check"></i> COA</a></li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Fi Periode<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/accounting/acc-periode']); ?>"><i class="fa fa-check"></i> Periodes</a></li>
                                <li><a href="<?= Url::to(['/accounting/acc-periode/close']); ?>"><i class="fa fa-check"></i> Closing</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/accounting/general-ledger']); ?>"><i class="fa fa-check"></i> Journals<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/accounting/general-ledger/create']); ?>"><i class="fa fa-check"></i> Manual Journal</a></li>
                                <li><a href="<?= Url::to(['/accounting/journal-template']); ?>"><i class="fa fa-check"></i> Journal Template</a></li>
                            </ul>
                        </li>
                        <!--<li><a href="#"><i class="fa fa-check"></i> General Ledger</a></li>-->
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Invoices<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/accounting/invoice', 'Invoice[type]' => backend\models\accounting\Invoice::TYPE_INCOMING]); ?>"><i class="fa fa-check"></i> Incoming</a></li>
                                <li><a href="<?= Url::to(['/accounting/invoice', 'Invoice[type]' => backend\models\accounting\Invoice::TYPE_OUTGOING]); ?>"><i class="fa fa-check"></i> Outgoing</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Payment<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-check"></i> Biaya-biaya</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Pembelian Asset</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Setoran Bank</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Piutang Karyawan</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Prive Owner</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart text-aqua"></i>
                        <span>Reports</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="#"><i class="fa fa-check text-aqua"></i> Sales Report<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?= Url::to(['/vsales/index']); ?>"><i class="fa fa-check"></i> Status Order</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> ...</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> ...</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> Stocks<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-check"></i> ...</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> ...</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> ...</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check"></i> FI & Accounting<i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-check"></i> GL</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Neraca</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Laba Rugi</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Perubahan Modal</a></li>
                                <li><a href="#"><i class="fa fa-check"></i> Arus Kas</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
<?php endif; ?>
            <li class="treeview">
                <a href="<?= Url::to(['/site/index']); ?>"><i class="fa fa-key text-danger"></i> <span>Auth Control</span></a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Url::to(['/site/login']); ?>"><i class="fa fa-unlock"></i> Login</a></li>
                        <?php else: ?>
                        <li><a href="<?= Url::to(['/site/logout']); ?>"><i class="fa fa-lock"></i> Logout</a></li>
<?php endif; ?>
                </ul>
            </li>
        </ul>