<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 class="titulo-dashboard">Dashboard — Painel Administrativo</h2>

<div class="dashboard-container">

    <!-- CARD PRODUTOS -->
    <div class="card info-card card-produtos">
        <div class="card-header">
            <i class="fa fa-box"></i>
            <span>Produtos</span>
        </div>
        <div class="card-value"><?= $totalProdutos ?></div>
        <div class="card-mini-chart"></div>
    </div>

    <!-- CARD CLIENTES -->
    <div class="card info-card card-clientes">
        <div class="card-header">
            <i class="fa fa-users"></i>
            <span>Clientes</span>
        </div>
        <div class="card-value"><?= $totalClientes ?></div>
        <div class="card-mini-chart"></div>
    </div>

    <!-- CARD PEDIDOS -->
    <div class="card info-card card-pedidos">
        <div class="card-header">
            <i class="fa fa-shopping-cart"></i>
            <span>Pedidos</span>
        </div>
        <div class="card-value"><?= $totalPedidos ?></div>
        <div class="card-mini-chart"></div>
    </div>

    <!-- CARD FATURAMENTO -->
    <div class="card info-card card-faturamento">
        <div class="card-header">
            <i class="fa fa-dollar-sign"></i>
            <span>Faturamento</span>
        </div>
        <div class="card-value">R$ <?= number_format($faturamento, 2, ',', '.') ?></div>
        <div class="card-mini-chart"></div>
    </div>

</div>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

/* Título */
.titulo-dashboard {
    text-align:center;
    margin:30px 0;
    font-family:Arial, sans-serif;
    font-size:28px;
    font-weight:bold;
}

/* Container geral */
.dashboard-container {
    display:flex;
    gap:25px;
    flex-wrap:wrap;
    justify-content:center;
    padding:10px;
}

/* Cards gerais */
.card {
    width:240px;
    background:white;
    border-radius:14px;
    padding:20px;
    color:#fff;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    position:relative;
    overflow:hidden;
}

.card-header {
    display:flex;
    align-items:center;
    gap:10px;
    font-size:18px;
    font-weight:bold;
}

.card-value {
    font-size:36px;
    font-weight:bold;
    margin:20px 0 10px;
}

/* Mini gráfico decorativo */
.card-mini-chart {
    height:40px;
    width:100%;
    background:rgba(255,255,255,0.4);
    border-radius:8px;
    margin-top:10px;
    position:relative;
    overflow:hidden;
}
.card-mini-chart::before {
    content:'';
    position:absolute;
    height:100%;
    width:130%;
    background:rgba(255,255,255,0.7);
    clip-path:polygon(0 70%, 20% 40%, 40% 60%, 60% 30%, 80% 50%, 100% 20%, 100% 100%, 0 100%);
    opacity:0.5;
}

/* Cores individuais */
.card-produtos     { background:#4CAF50; }
.card-clientes     { background:#2196F3; }
.card-pedidos      { background:#FF9800; }
.card-faturamento  { background:#E53935; }

/* Responsivo */
@media (max-width:900px) {
    .card { width:45%; }
}
@media (max-width:600px) {
    .card { width:100%; }
}
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?>
