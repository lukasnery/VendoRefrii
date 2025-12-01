<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 style="text-align:center; margin:20px 0; font-family:Arial, sans-serif;">Dashboard - Painel Administrativo</h2>

<div style="display:flex; gap:20px; flex-wrap:wrap; justify-content:center;">

    <div style="flex:1 1 200px; max-width:250px; background:#4CAF50; color:white; padding:25px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.2); text-align:center;">
        <h3><i class="fa fa-box"></i> Produtos</h3>
        <p style="font-size:28px; font-weight:bold; margin:15px 0;"><?= $totalProdutos ?></p>
    </div>

    <div style="flex:1 1 200px; max-width:250px; background:#2196F3; color:white; padding:25px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.2); text-align:center;">
        <h3><i class="fa fa-users"></i> Clientes</h3>
        <p style="font-size:28px; font-weight:bold; margin:15px 0;"><?= $totalClientes ?></p>
    </div>

    <div style="flex:1 1 200px; max-width:250px; background:#FF9800; color:white; padding:25px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.2); text-align:center;">
        <h3><i class="fa fa-shopping-cart"></i> Pedidos</h3>
        <p style="font-size:28px; font-weight:bold; margin:15px 0;"><?= $totalPedidos ?></p>
    </div>

    <div style="flex:1 1 200px; max-width:250px; background:#f44336; color:white; padding:25px; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.2); text-align:center;">
        <h3><i class="fa fa-dollar-sign"></i> Faturamento</h3>
        <p style="font-size:28px; font-weight:bold; margin:15px 0;">R$ <?= number_format($faturamento, 2, ',', '.') ?></p>
    </div>

</div>

<style>
    /* Ícones Font Awesome */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

    /* Responsivo */
    @media(max-width:900px){
        div[style*="flex:1 1 200px"] {
            flex:1 1 45%;
            max-width:none;
        }
    }

    @media(max-width:500px){
        div[style*="flex:1 1 200px"] {
            flex:1 1 100%;
        }
    }
</style>

<?php include __DIR__ . '/../layout/footer.php'; ?>
    