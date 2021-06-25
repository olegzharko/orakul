import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { SelectItem } from '../../../../../../../../../../../../../../types';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
import reqImmovablePayment from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovablePayment';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';

type InitialData = {
  sign_date: any,
  final_date: any,
  reg_num: string | null,
  first_part_grn: number | null,
  client_id: number | null,
  clients?: SelectItem[],
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useSecurityPayment = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [clients, setClients] = useState<SelectItem[]>([]);
  // Initial data
  const [data, setData] = useState<InitialData>({
    sign_date: null,
    final_date: null,
    reg_num: null,
    first_part_grn: null,
    client_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      sign_date: null,
      final_date: null,
      reg_num: null,
      first_part_grn: null,
      client_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        sign_date: formatDate(data.sign_date),
        final_date: formatDate(data.final_date),
      };

      const { success, message } = await reqImmovablePayment(token, id, 'PUT', reqData);
      dispatch(
        setModalInfo({
          open: true,
          success,
          message,
        })
      );
    }
  }, [data, token]);

  useEffect(() => {
    setClients(initialData?.clients || []);
    setData({
      sign_date: initialData?.sign_date
        ? changeMonthWitDate(initialData?.sign_date) : null,
      final_date: initialData?.final_date
        ? changeMonthWitDate(initialData?.final_date) : null,
      reg_num: initialData?.reg_num || null,
      first_part_grn: initialData?.first_part_grn || null,
      client_id: initialData?.client_id || null,
    });
  }, [initialData]);

  return {
    data,
    clients,
    setData,
    onClear,
    onSave,
  };
};
