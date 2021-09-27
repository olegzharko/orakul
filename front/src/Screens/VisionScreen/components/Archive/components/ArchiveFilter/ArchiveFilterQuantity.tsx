import React from 'react';

type ArchiveFilterQuantityProps = {
  quantity: number;
}

const ArchiveFilterQuantity = ({ quantity }: ArchiveFilterQuantityProps) => (
  <div className="quantity">
    <span>
      Знайдено: &nbsp;
      {quantity}
    </span>
  </div>
);

export default ArchiveFilterQuantity;
