import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useCallback, useMemo, useState, useEffect } from 'react';
import { State } from '../../../../../../../../../../store/types';
import reqDeveloper from '../../../../../../../../../../services/generator/Developer/reqDeveloper';

type Developer = {
  title: string;
  color: string;
  info: {
    title: string;
    value: string;
  }[]
}

export const useFields = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { developerId } = useParams<{ developerId: string }>();

  const [developer, setDeveloper] = useState<Developer>();
  const [banData, setBanData] = useState({
    date: new Date(),
    number: '',
    pass: false,
  });

  const onBanDataSave = useCallback(() => console.log('save'), []);
  const banDataSaveDisabled = useMemo(() => !banData.number || !banData.date, [banData]);

  useEffect(() => {
    const developerIsId = !Number.isNaN(parseFloat(developerId));
    if (token && developerIsId) {
      (async () => {
        const res = await reqDeveloper(token, developerId);

        if (res.success) {
          setDeveloper(res.data.dev_company);
        }
      })();
    }
  }, [token]);

  return {
    developer,
    banData,
    banDataSaveDisabled,
    setBanData,
    onBanDataSave,
  };
};
