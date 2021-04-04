import { useMemo, useState } from 'react';

export const useSellerBan = () => {
  const [data, setData] = useState<any>();

  const initialData = useMemo(() => ({
    date: new Date(),
    number: '',
    pass: false,
  }), []);

  return {
    initialData,
    setData,
  };
};
