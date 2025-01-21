const parsePrice = (priceString) => {
    const cleaned = priceString.replace(/[^\d,]/g, '').replace(',', '.');
    return parseFloat(cleaned);
};

const calculateOrderDetailTotal = (orderDetail) => {
    let productPrice =
        parsePrice(orderDetail.product.price) * orderDetail.quantity;
    let additionalPrice = 0;

    orderDetail.order_detail_additionals.forEach((additional) => {
        additionalPrice +=
            additional.order_detail_additionable.additional_price *
            orderDetail.quantity;
    });

    return {
        productPrice,
        additionalPrice,
        total: productPrice + additionalPrice,
    };
};

export const calculateOrderTotal = (order) => {
    let grandTotal = 0;
    const detailsTotal = order.order_details.map((detail) => {
        const totalPerDetail = calculateOrderDetailTotal(detail);
        grandTotal += totalPerDetail.total;
        return {
            id: detail.id,
            productName: detail.product.name,
            ...totalPerDetail,
        };
    });

    return {
        detailsTotal,
        grandTotal,
    };
};

export const calculateByOrderDetailId = (order, id) => {
    const detail = order.order_details.find((detail) => detail.id === id);
    if (!detail) {
        return `Order detail with ID ${id} not found.`;
    }

    const totalPerDetail = calculateOrderDetailTotal(detail);
    return {
        id: detail.id,
        productName: detail.product.name,
        ...totalPerDetail,
    };
};
