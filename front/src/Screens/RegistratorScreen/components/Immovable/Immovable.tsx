import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import InputWithCopy from '../../../../components/InputWithCopy';
import SectionWithTitle from '../../../../components/SectionWithTitle';
import { RegistratorNavigationTypes } from '../../useRegistratorScreen';

type Props = {
  onImmovableChange: (id: string, type: RegistratorNavigationTypes) => void;
  data: any;
}

const Immovable = ({ onImmovableChange, data }: Props) => {
  const { id } = useParams<{ id: string }>();

  useEffect(() => onImmovableChange(id, RegistratorNavigationTypes.IMMOVABLE), [id]);

  if (!data) {
    return null;
  }

  return (
    <div className="registrator__immovable">
      <SectionWithTitle title="Заборони по нерухомості">
        <div className="registrator__immovable-content">
          <InputWithCopy label="Реєстраційни номер" value={data.immovable_code} disabled />
        </div>
      </SectionWithTitle>
    </div>
  );
};

export default Immovable;
