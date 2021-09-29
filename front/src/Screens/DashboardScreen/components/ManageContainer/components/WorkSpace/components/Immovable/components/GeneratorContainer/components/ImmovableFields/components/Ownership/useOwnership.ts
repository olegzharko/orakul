import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import reqImmovableOwnership from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableOwnership';

type InitialData = {
  reg_date: any;
  reg_number: number | string;
  discharge_date: any;
  discharge_number: number | string;
  notary_id: string | null;
  notary?: any,
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useOwnership = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [notary, setNotary] = useState([]);

  // Initial data
  const [data, setData] = useState<InitialData>({
    reg_date: null,
    reg_number: '',
    discharge_date: null,
    discharge_number: '',
    notary_id: null,
  });

  const onClear = useCallback(() => {
    setData({
      reg_date: null,
      reg_number: '',
      discharge_date: null,
      discharge_number: '',
      notary_id: null,
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        reg_date: formatDate(data.reg_date),
        discharge_date: formatDate(data.discharge_date),
      };

      const { success, message } = await reqImmovableOwnership(token, id, 'PUT', reqData);
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
    setData({
      reg_date: initialData?.reg_date ? changeMonthWitDate(initialData?.reg_date) : null,
      reg_number: initialData?.reg_number || '',
      discharge_date: initialData?.discharge_date
        ? changeMonthWitDate(initialData?.discharge_date) : null,
      discharge_number: initialData?.discharge_number || '',
      notary_id: initialData?.notary_id || null,
    });
    setNotary(initialData?.notary || []);
  }, [initialData]);

  return {
    data,
    notary,
    setData,
    onClear,
    onSave,
  };
};
