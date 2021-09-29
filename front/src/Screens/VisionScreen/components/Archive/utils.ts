export const formatArchiveTableRawValue = (val: any) => {
  if (Array.isArray(val)) {
    return val;
  }

  return [val];
};
