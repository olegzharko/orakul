import { useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { NotarizeNavigationTypes } from '../../useNotarizeScreen';
import { editPowerOfAttorneyStatus } from '../../../../store/notarize/actions';
import { CheckBanFieldsData } from '../../../../components/CheckBanFields/CheckBanFields';
import { changeMonthWitDate, formatDate } from '../../../../utils/formatDates';

export type Props = {
  onPathChange: (id: string, type: NotarizeNavigationTypes) => void;
  powerOfAttorney: any;
}

export const usePowerOfAttorney = ({ onPathChange, powerOfAttorney }: Props) => {
  const { id } = useParams<{ id: string }>();

  const dispatch = useDispatch();

  const [data, setData] = useState<CheckBanFieldsData>({
    date: new Date(),
    number: '',
    pass: false,
  });

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  const onSave = useCallback(() => {
    dispatch(editPowerOfAttorneyStatus(id, { ...data, date: formatDate(data.date) }));
  }, [data, dispatch, id]);

  useEffect(() => {
    setData({
      date: powerOfAttorney?.date ? changeMonthWitDate(powerOfAttorney?.date) : new Date(),
      number: powerOfAttorney?.number || '',
      pass: powerOfAttorney?.pass || false,
    });
  }, [powerOfAttorney]);

  useEffect(() => onPathChange(id, NotarizeNavigationTypes.POWER_OF_ATTORNEY), [id, onPathChange]);

  return {
    data,
    disableSaveButton,
    setData,
    onSave,
  };
};
