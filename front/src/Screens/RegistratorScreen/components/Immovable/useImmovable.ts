import { useDispatch } from 'react-redux';
import { useEffect, useState, useCallback, useMemo } from 'react';
import { useParams, useHistory } from 'react-router-dom';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';
import { editDeveloperStatus, editImmovableStatus } from '../../../../store/registrator/actions';

export type Props = {
  onPathChange: (id: string, type: RegistratorNavigationTypes) => void;
  immovable: any;
}

export type DeveloperCardState = {
  date: Date,
  number: string,
  pass: boolean,
}

export const useImmovable = ({ onPathChange, immovable }: Props) => {
  const history = useHistory();
  const { id } = useParams<{ id: string }>();

  const dispatch = useDispatch();

  const [data, setData] = useState<DeveloperCardState>({
    date: new Date(),
    number: '',
    pass: false,
  });

  const disableSaveButton = useMemo(() => !data.date || !data.number, [data]);

  const onSave = useCallback(() => {
    dispatch(editImmovableStatus(id, data));
  }, [data, id]);

  const onPrevButtonClick = useCallback(() => {
    if (!immovable.prev) return;

    history.push(`/immovable/${immovable.prev}`);
  }, [immovable]);

  const onNextButtonClick = useCallback(() => {
    if (!immovable.next) return;

    history.push(`/immovable/${immovable.next}`);
  }, [immovable]);

  useEffect(() => {
    setData({
      date: new Date(),
      number: '',
      pass: false,
    });
  }, [id]);

  useEffect(() => onPathChange(id, RegistratorNavigationTypes.IMMOVABLE), [id]);

  return {
    data,
    disableSaveButton,
    setData,
    onPrevButtonClick,
    onNextButtonClick,
    onSave,
  };
};
