import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useState, useEffect } from 'react';
import { State } from '../../../../../../../../../../store/types';
import reqDeveloper from '../../../../../../../../../../services/generator/Developer/reqDeveloper';
import { isNumber } from '../../../../../../../../../../utils/numbers';

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
  const { developerId, clientId } = useParams<{ developerId: string, clientId: string }>();

  const [developer, setDeveloper] = useState<Developer>();
  const [spouse, setSpouse] = useState([]);

  useEffect(() => {
    const developerIsId = isNumber(developerId);
    if (token && developerIsId) {
      (async () => {
        const res = await reqDeveloper(token, developerId, clientId);

        if (res.success) {
          setDeveloper(res.data.dev_company);
          setSpouse(res.data.ceo_spouse_info);
        }
      })();
    }
  }, [token]);

  return {
    developer,
    spouse,
  };
};
