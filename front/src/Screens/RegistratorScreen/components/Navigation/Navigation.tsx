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
        className={`navigation-button ${
          selected === RegistratorNavigationTypes.DEVELOPER ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(RegistratorNavigationTypes.DEVELOPER)}
      >
        <img src="/icons/navigation/developer.svg" alt="developer" />
        Заборони на продавця
      </button>
      <button
        className={`navigation-button ${
          selected === RegistratorNavigationTypes.IMMOVABLE ? 'selected' : ''
        }`}
        type="button"
        onClick={() => handleClick(RegistratorNavigationTypes.IMMOVABLE)}
      >
        <img src="/icons/navigation/immovable.svg" alt="immovable" />
        Заборони по нерухомості
      </button>
    </ControlPanel>
  );
};

export default Navigation;
