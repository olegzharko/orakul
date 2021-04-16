import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableExchange from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableExchange';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../store/types';

type InitialData = {
  exchange_rate: string,
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useExchangeRate = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [exchangeRate, setExchangeRate] = useState('');

  const onClear = useCallback(() => {
    setExchangeRate('');
  }, []);

  const onRefreshRate = useCallback(async () => {
    if (token) {
      const res = await reqImmovableExchange(token, '', 'GET', 'MINFIN');
      if (res.success) {
        setExchangeRate(res.data.exchange_rate);
      }
    }
  }, [token]);

  const onSave = useCallback(async () => {
    if (token) {
      const { success, message } = await reqImmovableExchange(token, id, 'PUT', null, { exchange_rate: exchangeRate });

      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [exchangeRate, token]);

  const isSaveButtonDisable = useMemo(
    () => !exchangeRate, [exchangeRate]
  );

  useEffect(() => {
    setExchangeRate(initialData?.exchange_rate || '');
  }, [initialData]);

  return {
    exchangeRate,
    isSaveButtonDisable,
    setExchangeRate,
    onClear,
    onSave,
    onRefreshRate
  };
};
