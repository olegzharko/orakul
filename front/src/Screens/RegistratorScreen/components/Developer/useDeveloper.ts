import { useEffect, useState, useCallback } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';

export type Props = {
  onImmovableChange: (id: string, type: RegistratorNavigationTypes) => void;
  data: any;
}

export const useDeveloper = ({ onImmovableChange, data }: Props) => {
  const history = useHistory();
  const { id } = useParams<{ id: string }>();

  const [date, setDate] = useState();
  const [number, setNumber] = useState('');
  const [validation, setValidation] = useState<boolean>(false);

  useEffect(() => {
    setDate(undefined);
    setNumber('');
    setValidation(false);
  }, [id]);

  useEffect(() => onImmovableChange(id, RegistratorNavigationTypes.DEVELOPER), [id]);

  const onPrevButtonClick = useCallback(() => {
    if (!data.prew) return;
    history.push(`/developer/${data.prew}`);
  }, [data]);

  const onNextButtonClick = useCallback(() => {
    if (!data.next) return;
    history.push(`/developer/${data.next}`);
  }, [data]);

  return {
    date,
    number,
    validation,
    setDate,
    setNumber,
    setValidation,
    onPrevButtonClick,
    onNextButtonClick,
  };
};
