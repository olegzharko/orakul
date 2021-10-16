import { useCallback, useState, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import reqImmovableTermination from '../../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableTermination';
import { setModalInfo } from '../../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../../../../../../../../types';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../../utils/formatDates';

type InitialData = {
  notary_id: string | null,
  reg_date: any,
  reg_number: string | null,
  price_grn: string | null,
  price_dollar: string | null,
  first_client_id: string | null,
  second_client_id: string | null,
  notary?: SelectItem[],
  clients?: SelectItem[],
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useTermination = ({ id, initialData }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [notaries, setNotaries] = useState<SelectItem[]>([]);
  const [clients, setClients] = useState<SelectItem[]>([]);
  const [data, setData] = useState<InitialData>({
    notary_id: null,
    reg_date: null,
    reg_number: null,
    price_grn: null,
    price_dollar: null,
    first_client_id: null,
    second_client_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      notary_id: null,
      reg_date: null,
      reg_number: null,
      price_grn: null,
      price_dollar: null,
      first_client_id: null,
      second_client_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        reg_date: formatDate(data.reg_date),
      };

      const { success, message } = await reqImmovableTermination(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, dispatch, id, token]);

  useEffect(() => {
    setNotaries(initialData?.notary || []);
    setClients(initialData?.clients || []);
    setData({
      notary_id: initialData?.notary_id || null,
      reg_number: initialData?.reg_number || null,
      price_grn: initialData?.price_grn || null,
      price_dollar: initialData?.price_dollar || null,
      reg_date: initialData?.reg_date ? changeMonthWitDate(initialData?.reg_date) : null,
      first_client_id: initialData?.first_client_id || null,
      second_client_id: initialData?.second_client_id || null,
    });
  }, [initialData]);

  return {
    notaries,
    clients,
    data,
    onClear,
    onSave,
    setData,
  };
};
