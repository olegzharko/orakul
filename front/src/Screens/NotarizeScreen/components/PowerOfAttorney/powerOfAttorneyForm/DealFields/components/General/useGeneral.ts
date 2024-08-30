import { useCallback, useEffect, useMemo, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useParams } from 'react-router-dom'; // Third-party import should come first

import reqImmovableGeneral from '../../../../../../../../services/notarize/PowerOfAttorney/General/reqPowerOfAttorneyGeneral';
import { setModalInfo } from '../../../../../../../../store/main/actions';
import { State } from '../../../../../../../../store/types';
import { SelectItem } from '../../../../../../../../types';
import { formatDate, changeMonthWitDate } from '../../../../../../../../utils/formatDates';

type InitialData = {
  car_make: string;
  commercial_description: string;
  type: string;
  special_notes: string;
  year_of_manufacture: string;
  vin_code: string;
  registration_number: string;
  registered: string;
  registration_date: any;
  registration_certificate: string;
}

export type Props = {
  id: string,
  initialData?: InitialData,
}

export const useGeneral = ({ initialData, id }: Props) => {
  const dispatch = useDispatch();
  const { token } = useSelector((state: State) => state.main.user);

  const [data, setData] = useState<InitialData>({
    car_make: '',
    commercial_description: '',
    type: '',
    special_notes: '',
    year_of_manufacture: '',
    vin_code: '',
    registration_number: '',
    registered: '',
    registration_date: null,
    registration_certificate: '',
  });

  const onClear = useCallback(() => {
    setData({
      car_make: '',
      commercial_description: '',
      type: '',
      special_notes: '',
      year_of_manufacture: '',
      vin_code: '',
      registration_number: '',
      registered: '',
      registration_date: null,
      registration_certificate: '',
    });
  }, []);

  const onSave = useCallback(async () => {
    if (token) {
      const reqData = {
        ...data,
        registration_date: formatDate(data.registration_date),
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
  }, [data, dispatch, id, token]);

  useEffect(() => {
    setData({
      car_make: initialData?.car_make ?? '',
      commercial_description: initialData?.commercial_description ?? '',
      type: initialData?.type ?? '',
      special_notes: initialData?.special_notes ?? '',
      year_of_manufacture: initialData?.year_of_manufacture ?? '',
      vin_code: initialData?.vin_code ?? '',
      registration_number: initialData?.registration_number ?? '',
      registered: initialData?.registered ?? '',
      registration_date: initialData?.registration_date
        ? changeMonthWitDate(initialData?.registration_date) : null,
      registration_certificate: initialData?.registration_certificate ?? '',
    });
  }, [initialData]);

  const isSaveButtonDisable = useMemo(
    () => !data.car_make
      || !data.commercial_description
      || !data.year_of_manufacture,
    [data.vin_code, data.registration_number, data.registered]
  );

  return {
    data,
    isSaveButtonDisable,
    setData,
    onClear,
    onSave,
  };
};
