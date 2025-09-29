function setupAutocomplete(input, items, fuzzySearchFn) {
  let suggestionList = items;
  // console.log(input, items, fuzzySearchFn);
  function updateSuggstionList(newItems) {
    suggestionList = newItems;
  }
  input.addEventListener("input", function () {
    const parent = input.parentNode;
    const slc = parent.querySelector(".suggestionList");

    const val = input.value.toLowerCase();
    slc.innerHTML = "";
    slc.style.border = "1px solid #ddd";
    if (!val) {
      slc.style.border = "none";
      return;
    }
    console.log({ input, slc });
    suggestionList
      .filter((item) => fuzzySearchFn(item, val))
      .forEach((item) => {
        const div = document.createElement("div");
        div.textContent = item;
        div.onclick = () => {
          input.value = item;
          slc.style.border = "none";
          slc.innerHTML = "";
        };
        slc.appendChild(div);
      });
  });

  return { updateSuggstionList };
}
