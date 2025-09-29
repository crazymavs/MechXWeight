function fuzzySearch(str, query) {
  str = str.toLowerCase();
  query = query.toLowerCase();
  let i = 0,
    lastSearched = -1,
    current = query[i];
  while (current) {
    if (!~(lastSearched = str.indexOf(current, lastSearched + 1))) {
      return false;
    }
    current = query[++i];
  }
  return true;
}
