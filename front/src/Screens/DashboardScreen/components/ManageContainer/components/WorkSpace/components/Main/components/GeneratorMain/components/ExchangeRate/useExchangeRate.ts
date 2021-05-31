import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import reqImmovableExchange from '../../../../../../../../../../../../services/generator/Immovable/reqImmovableExchange';
import { setModalInfo } from '../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../store/types';

type InitialData = {
  contract_buy: string,
  exchange_rate: string,
  contract_sell: string,
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

  const onClear = useCallback(() => {
    setContractBuy('');
    setContractSell('');
    setExchangeRate('');
  }, []);

  const onRefreshRate = useCallback(async () => {
    if (token) {
      const res = await reqImmovableExchange(token, '', 'GET', 'MINFIN');
      if (res.success) {
        setContractBuy(res.data.contract_buy);
        setContractSell(res.data.contract_sell);
        setExchangeRate(res.data.exchange_rate);
      }
    }
  }, [token]);

  const onSave = useCallback(async () => {
    if (token) {
      const data = {
        contract_buy: contractBuy,
        contract_sell: contractSell,
        exchange_rate: exchangeRate,
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
  }, [contractBuy, contractSell, exchangeRate, token]);

  const isSaveButtonDisable = useMemo(
    () => !contractBuy || !contractSell || !exchangeRate, [contractBuy, contractSell, exchangeRate]
  );

  useEffect(() => {
    setContractBuy(initialData?.contract_buy || '');
    setContractSell(initialData?.contract_sell || '');
    setExchangeRate(initialData?.exchange_rate || '');
  }, [initialData]);

  return {
    contractBuy,
    contractSell,
    exchangeRate,
    isSaveButtonDisable,
    setContractBuy,
    setContractSell,
    setExchangeRate,
    onClear,
    onSave,
    onRefreshRate
  };
};
