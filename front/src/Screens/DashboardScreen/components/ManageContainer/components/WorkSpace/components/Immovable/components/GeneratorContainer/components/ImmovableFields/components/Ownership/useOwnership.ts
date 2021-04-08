import { useCallback, useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { changeMonthWitDate, formatDate } from '../../../../../../../../../../../../../../utils/formatDates';
import reqImmovableGeneral from '../../../../../../../../../../../../../../services/generator/Immovable/reqImmovableGeneral';
import { setModalInfo } from '../../../../../../../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../../../../../../../types';

type InitialData = {
  reg_date: any;
  reg_number: number | string;
  discharge_date: any;
  discharge_number: number | string;
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useOwnership = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  // Initial data
  const [data, setData] = useState<InitialData>({
    reg_date: null,
    reg_number: '',
    discharge_date: null,
    discharge_number: '',
  });

  const onClear = useCallback(() => {
    setData({
      reg_date: null,
      reg_number: '',
      discharge_date: null,
      discharge_number: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        reg_date: formatDate(data.reg_date),
        discharge_date: formatDate(data.discharge_date),
      };

      const { success, message } = await reqImmovableGeneral(token, id, 'PUT', reqData);
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
    setData({
      reg_date: initialData?.reg_date ? new Date(changeMonthWitDate(initialData?.reg_date)) : null,
      reg_number: initialData?.reg_number || '',
      discharge_date: initialData?.discharge_date
        ? new Date(changeMonthWitDate(initialData?.discharge_date)) : null,
      discharge_number: initialData?.discharge_number || '',
    });
  }, [initialData]);

  return {
    data,
    setData,
    onClear,
    onSave,
  };
};
