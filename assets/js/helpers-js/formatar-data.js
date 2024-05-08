function formatarDatas(date) {

    let dataInglesa = date.split('-');
    let dataBr = `${dataInglesa[2]}/${dataInglesa[1]}/${dataInglesa[0]}`

    return dataBr;
}