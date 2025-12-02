<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(180deg, #6a11cb 0%, #2575fc 100%) !important;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}" style="background: rgba(0,0,0,0.2); border-bottom: 2px solid rgba(255,255,255,0.1);">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="font-weight: 700; letter-spacing: 0.5px;">LAB PTI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" style="border-top: 1px solid rgba(255,255,255,0.2);">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}" style="padding: 12px 20px; transition: all 0.3s ease;">
                    <i class="fas fa-fw fa-chart-line" style="margin-right: 10px;"></i>
                    <span style="font-weight: 500;">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('barang.index') }}" style="padding: 12px 20px; transition: all 0.3s ease;">
                    <i class="fas fa-fw fa-boxes" style="margin-right: 10px;"></i>
                    <span style="font-weight: 500;">Daftar Barang</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('statusbarang.index') }}" style="padding: 12px 20px; transition: all 0.3s ease;">
                    <i class="fas fa-fw fa-clipboard-list" style="margin-right: 10px;"></i>
                    <span style="font-weight: 500;">Status Barang</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}" style="padding: 12px 20px; transition: all 0.3s ease;">
                    <i class="fas fa-fw fa-exchange-alt" style="margin-right: 10px;"></i>
                    <span style="font-weight: 500;">Transaksi</span>
                </a>
            </li>

            @if(auth()->check() && auth()->user()->isAdmin())
              <li class="nav-item">
                <a class="nav-link" href="{{ route('petugas.index') }}" style="padding: 12px 20px; transition: all 0.3s ease;">
                    <i class="fas fa-fw fa-users" style="margin-right: 10px;"></i>
                    <span style="font-weight: 500;">Petugas</span>
                </a>
              </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider mt-5" style="border-top: 1px solid rgba(255,255,255,0.2);">

        </ul>