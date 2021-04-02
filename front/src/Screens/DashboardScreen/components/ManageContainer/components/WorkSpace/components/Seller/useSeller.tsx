import { useCallback, useMemo, useState } from 'react';

export const useSeller = () => {
  const [banData, setBanData] = useState({
    date: new Date(),
    number: '',
    pass: false,
  });

  const onBanDataSave = useCallback(() => console.log('save'), []);
  const banDataSaveDisabled = useMemo(() => !banData.number || !banData.date, [banData]);

  const signerDataSaveDisabled = useMemo(() => false, [banData]);

  return {
    banData,
    banDataSaveDisabled,
    signerDataSaveDisabled,
    setBanData,
    onBanDataSave,
  };
};
