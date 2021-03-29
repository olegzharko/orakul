import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import InputWithCopy from '../../../../components/InputWithCopy';
import SectionWithTitle from '../../../../components/SectionWithTitle';

type Props = {
  onImmovableChange: (id: string) => void;
  data: any;
}

const Developer = ({ onImmovableChange, data }: Props) => {
  const { id } = useParams<{ id: string }>();

  useEffect(() => onImmovableChange(id), [id]);

  if (!data) {
    return null;
  }

  return (
    <div className="registrator__developer">
      <SectionWithTitle title={data.title}>
        <div className="registrator__developer-content">
          <InputWithCopy label="ПІБ" value={data.full_name} disabled />
          <InputWithCopy label="Код" value={data.tax_code} disabled />
        </div>
      </SectionWithTitle>
    </div>
  );
};

export default Developer;
