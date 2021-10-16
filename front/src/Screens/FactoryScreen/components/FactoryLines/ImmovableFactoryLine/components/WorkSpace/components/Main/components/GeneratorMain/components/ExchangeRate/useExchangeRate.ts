import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import reqImmovableExchange from '../../../../../../../../../../../../../services/generator/Immovable/reqImmovableExchange';
import { setModalInfo } from '../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../store/types';

type InitialData = {
  contract_buy: string,
  exchange_rate: string,
  contract_sell: string,
  exchange_date: string,
  nbu_ask: string;
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useExchangeRate = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [contractBuy, setContractBuy] = useState('');
  const [contractSell, setContractSell] = useState('');
  const [exchangeRate, setExchangeRate] = useState('');
  const [nbu, setNbu] = useState('');

  const onClear = useCallback(() => {
    setContractBuy('');
    setContractSell('');
    setExchangeRate('');
    setNbu('');
  }, []);

  const onRefreshRate = useCallback(async () => {
    if (token) {
      const res = await reqImmovableExchange(token, '', 'GET', 'MINFIN');
      if (res.success) {
        setContractBuy(res.data.contract_buy);
        setContractSell(res.data.contract_sell);
        setExchangeRate(res.data.exchange_rate);
        setNbu(res.data.nbu_ask);
      }
    }
  }, [token]);

  const onSave = useCallback(async () => {
    if (token) {
      const data = {
        contract_buy: contractBuy,
        contract_sell: contractSell,
        exchange_rate: exchangeRate,
        nbu_ask: nbu,
      };
      const { success, message } = await reqImmovableExchange(token, id, 'PUT', null, data);

      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [token, contractBuy, contractSell, exchangeRate, nbu, id, dispatch]);

  const isSaveButtonDisable = useMemo(
    () => !contractBuy
      || !contractSell
      || !exchangeRate
      || !nbu,
    [contractBuy, contractSell, exchangeRate, nbu]
  );

  useEffect(() => {
    setContractBuy(initialData?.contract_buy || '');
    setContractSell(initialData?.contract_sell || '');
    setExchangeRate(initialData?.exchange_rate || '');
    setNbu(initialData?.nbu_ask || '');
  }, [initialData]);

  return {
    contractBuy,
    contractSell,
    exchangeRate,
    isSaveButtonDisable,
    nbu,
    setContractBuy,
    setContractSell,
    setExchangeRate,
    setNbu,
    onClear,
    onSave,
    onRefreshRate
  };
};
