import { useParams, useHistory } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { useCallback, useState, useEffect, useMemo } from 'react';

import { State } from '../../../../../../../../../../../store/types';
import reqNotaryData from '../../../../../../../../../../../services/generator/SideNotary/reqNotaryData';
import { setModalInfo } from '../../../../../../../../../../../store/main/actions';
import { isNumber } from '../../../../../../../../../../../utils/numbers';
import routes from '../../../../../../../../../../../routes';

type SideNotaryDenominativeData = {
  surname_n: string,
  name_n: string,
  patronymic_n: string,
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
  const { notaryId, lineItemId } = useParams<{ notaryId: string, lineItemId: string }>();

  const [denominative, setDenominate] = useState<SideNotaryDenominativeData>({
    surname_n: '',
    name_n: '',
    patronymic_n: '',
    activity_n: '',
  });
  const [ablative, setAblative] = useState<SideNotaryFblativeData>({
    name_o: '',
    surname_o: '',
    patronymic_o: '',
    activity_o: '',
  });

  const shouldLoadData = useMemo(() => notaryId !== 'create' && isNumber(notaryId), [notaryId]);

  useEffect(() => {
    // get NOTARY_DATA
    (async () => {
      if (token && shouldLoadData) {
        const res = await reqNotaryData(token, notaryId, '');

        if (res.success) {
          setDenominate({
            surname_n: res.data.surname_n || '',
            name_n: res.data.name_n || '',
            patronymic_n: res.data.patronymic_n || '',
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
  }, [token, notaryId, shouldLoadData]);

  const onDenominativeClear = useCallback(() => {
    setDenominate({
      surname_n: '',
      name_n: '',
      patronymic_n: '',
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
      const res = await reqNotaryData(token, id, lineItemId, 'PUT', data);

      dispatch(
        setModalInfo({
          open: true,
          success: res?.success,
          message: res?.message,
        })
      );

      if (res?.success && notaryId === 'create' && isNumber(res?.data.notary_id)) {
        history.push(
          routes.factory.lines.immovable.sections.sideNotaries.view.linkTo(
            lineItemId, res?.data.notary_id
          )
        );
      }
    }
  }, [
    denominative,
    ablative,
    shouldLoadData,
    notaryId,
    token,
    lineItemId,
    dispatch,
    history,
  ]);

  const isButtonDisabled = useMemo(() => Object.values(denominative).some((item) => !item)
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
