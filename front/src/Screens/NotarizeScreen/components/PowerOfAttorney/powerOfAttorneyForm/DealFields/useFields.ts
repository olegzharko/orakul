import { useParams } from 'react-router-dom';
import { useSelector } from 'react-redux';
import { useMemo, useState, useEffect } from 'react';

import { State } from '../../../../../../store/types';
import { isNumber } from '../../../../../../utils/numbers';
import reqPowerOfAttorneyGeneral from '../../../../../../services/notarize/PowerOfAttorney/General/reqPowerOfAttorneyGeneral';
import reqPowerOfAttorneyTemplate from '../../../../../../services/notarize/PowerOfAttorney/Template/reqPowerOfAttorneyTemplate';

export const useFields = () => {
  const { token } = useSelector((state: State) => state.main.user);
  const { id } = useParams<{ id: string }>();

  // Fields Data
  const [general, setGeneral] = useState();
  const [templates, setTemplates] = useState();

  const isCorrectId = useMemo(() => isNumber(id), [id]);

  useEffect(() => {
    if (token && isCorrectId) {
      // get GENERAL
      (async () => {
        const res = await reqPowerOfAttorneyGeneral(token, id);

        if (res?.success) {
          setGeneral(res.data);
        }
      })();

      // get TEMPLATES
      (async () => {
        const res = await reqPowerOfAttorneyTemplate(token, id);

        if (res?.success) {
          setTemplates(res.data);
        }
      })();
    }
  }, [token, isCorrectId, id]);

  return {
    id,
    general,
    templates,
  };
};
