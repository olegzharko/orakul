import * as React from 'react';
import { useHistory } from 'react-router-dom';
import ControlPanel from '../../../../components/ControlPanel';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';

type Props = {
  selected: RegistratorNavigationTypes;
  onSelect: (value: RegistratorNavigationTypes) => void;
}

const Navigation = ({ onSelect, selected }: Props) => {
  const history = useHistory();

  const handleClick = (type: RegistratorNavigationTypes) => {
    onSelect(type);
    history.push(`/${type}`);
  };

  return (
    <ControlPanel>
      <button
        className={`registrator__navigation-item ${
          selected === RegistratorNavigationTypes.IMMOVABLE ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(RegistratorNavigationTypes.IMMOVABLE)}
      >
        <img src="/icons/registrator/immovable.svg" alt="immovable" />
        Заборони на продавця
      </button>
      <button
        className={`registrator__navigation-item ${
          selected === RegistratorNavigationTypes.DEVELOPER ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(RegistratorNavigationTypes.DEVELOPER)}
      >
        <img src="/icons/registrator/developer.svg" alt="developer" />
        Заборони по нерухомості
      </button>
    </ControlPanel>
  );
};

export default Navigation;
