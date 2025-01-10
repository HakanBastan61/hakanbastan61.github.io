function calculateProfit() {
    // Kullanıcıdan verileri al
    const sellingPrice = parseFloat(document.getElementById('sellingPrice').value);
    const costPrice = parseFloat(document.getElementById('costPrice').value);
    const shippingCost = parseFloat(document.getElementById('shippingCost').value);
    const packagingCost = parseFloat(document.getElementById('packagingCost').value);
    const additionalCosts = parseFloat(document.getElementById('additionalCosts').value);
    const commissionRate = parseFloat(document.getElementById('commissionRate').value) / 100;
    const vatRate = parseFloat(document.getElementById('vatRate').value) / 100;

    // Gerekli alanlar kontrolü
    if (isNaN(sellingPrice) || isNaN(costPrice) || isNaN(shippingCost) || isNaN(packagingCost) || isNaN(additionalCosts) || isNaN(commissionRate) || isNaN(vatRate)) {
        alert("Lütfen tüm alanları doğru şekilde doldurun.");
        return;
    }

    // Ürün maliyeti hesaplama
    const totalProductCost = costPrice + shippingCost + packagingCost + additionalCosts;

    // Komisyon hesaplama
    const commission = sellingPrice * commissionRate;

    // KDV hesaplama
    const vat = sellingPrice * vatRate;

    // Toplam maliyet
    const totalCost = totalProductCost + commission + vat;

    // Kar hesaplama
    const profit = sellingPrice - totalCost;

    // Sonuçları ekrana yazdır
    document.getElementById('costSummary').innerText = `Toplam Ürün Maliyeti (KOMİSYON & KDV HARİÇ): ${totalProductCost.toFixed(2)} TL`;
    document.getElementById('commissionSummary').innerText = `Komisyon: ${commission.toFixed(2)} TL`;
    document.getElementById('vatSummary').innerText = `KDV: ${vat.toFixed(2)} TL`;
    document.getElementById('totalCostSummary').innerText = `Toplam Maliyet (KOMİSYON & KDV DAHİL): ${totalCost.toFixed(2)} TL`;
    document.getElementById('profitSummary').innerText = `Üründen Edeceğiniz Kar: ${profit.toFixed(2)} TL`;

    // Sonuçları göster
    document.getElementById('results').style.display = 'block';
}
