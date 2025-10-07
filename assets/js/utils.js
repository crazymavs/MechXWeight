if (typeof getLabelConfiguration === "undefined") {
  const getLabelConfiguration = async () => {
    const res = await getLabelConfigAPI();
    let newLables = {};
    if (res.status) {
      newLables = res.data.reduce((acc, item) => {
        acc[item.column_name] = item.label_name;
        return acc;
      }, {});
    }
    return {
      data: res.data,
      newLables,
    };
  };
  window.getLabelConfiguration = getLabelConfiguration; // export globally
}
