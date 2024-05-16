function carregaSelect2(classe, modal) {
  $(`.${classe}`).select2({
    dropdownParent: `#${modal}`,
    theme: "bootstrap-5",
  });
}