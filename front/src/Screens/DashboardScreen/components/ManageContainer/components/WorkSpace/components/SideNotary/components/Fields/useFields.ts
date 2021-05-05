import { useParams, useHistory } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect, useMemo } from 'react';
import { State } from '../../../../../../../../../../store/types';
import reqNotaryData from '../../../../../../../../../../services/generator/SideNotary/reqNotaryData';
import { setModalInfo } from '../../../../../../../../../../store/main/actions';

type SideNotaryDenominativeData = {
  surname_n: string,
  name_n: string,
  short_name: string,
  patronymic_n: string,
  short_patronymic: string,
  activity_n: string,
}

type SideNotaryFblativeData = {
  name_o: string,
  surname_o: string,
  patronymic_o: string,
  activity_o: string,
}

export const useFields = () => {
  const dispatch = useDispatch();
  const history = useHistory();
  const { token } = useSelector((state: State) => state.main.user);
  const { notaryId, clientId } = useParams<{ notaryId: string, clientId: string }>();

  const [denominative, setDenominate] = useState<SideNotaryDenominativeData>({
    surname_n: '',
    name_n: '',
    short_name: '',
    patronymic_n: '',
    short_patronymic: '',
    activity_n: '',
  });
  const [ablative, setAblative] = useState<SideNotaryFblativeData>({
    name_o: '',
    surname_o: '',
    patronymic_o: '',
    activity_o: '',
  });

  const shouldLoadData = useMemo(() => notaryId !== 'create' && !Number.isNaN(parseFloat(notaryId)), [notaryId]);

  useEffect(() => {
    // get NOTARY_DATA
    (async () => {
      if (token && shouldLoadData) {
        const res = await reqNotaryData(token, notaryId, '');

        if (res.success) {
          setDenominate({
            surname_n: res.data.surname_n || '',
            name_n: res.data.name_n || '',
            short_name: res.data.short_name || '',
            patronymic_n: res.data.patronymic_n || '',
            short_patronymic: res.data.short_patronymic || '',
            activity_n: res.data.activity_n || '',
          });

          setAblative({
            name_o: res.data.name_o || '',
            surname_o: res.data.surname_o || '',
            patronymic_o: res.data.patronymic_o || '',
            activity_o: res.data.activity_o || '',
          });
        }
      }
    })();
  }, [token, notaryId]);

  const onDenominativeClear = useCallback(() => {
    setDenominate({
      surname_n: '',
      name_n: '',
      short_name: '',
      patronymic_n: '',
      short_patronymic: '',
      activity_n: '',
    });
  }, []);

  const onAblativeClear = useCallback(() => {
    setAblative({
      name_o: '',
      surname_o: '',
      patronymic_o: '',
      activity_o: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    const data = { ...denominative, ...ablative };
    const id = shouldLoadData ? notaryId : '';

    if (token) {
      const res = await reqNotaryData(token, id, clientId, 'PUT', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && notaryId === 'create' && !Number.isNaN(parseFloat(res?.data.notary_id))) {
        history.push(`/side-notaries/${clientId}/${res?.data.notary_id}`);
      }
    }
  }, [denominative, ablative, token]);

  const isButtonDisabled = useMemo(() =>
    // eslint-disable-next-line implicit-arrow-linebreak
    Object.values(denominative).some((item) => !item)
    || Object.values(ablative).some((item) => !item), [denominative, ablative]);

  return {
    denominative,
    ablative,
    isButtonDisabled,
    setDenominate,
    setAblative,
    onDenominativeClear,
    onAblativeClear,
    onSave,
  };
};
